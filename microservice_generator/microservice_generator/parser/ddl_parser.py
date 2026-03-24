"""
SQL DDL parser — regex-based, targets MySQL dialect.
Handles CREATE TABLE with inline and table-level constraints.
"""

import re
from typing import Optional

from .models import SchemaModel, TableModel, ColumnModel, ForeignKeyModel

# Finds CREATE TABLE name ( — the body is extracted separately with paren tracking
_CREATE_TABLE_HEADER_RE = re.compile(
    r"CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?([`\"\[\]\w]+)\s*\(",
    re.IGNORECASE,
)


def parse_ddl(sql_text: str) -> SchemaModel:
    sql_text = _strip_comments(sql_text)
    tables: dict[str, TableModel] = {}

    for match in _CREATE_TABLE_HEADER_RE.finditer(sql_text):
        table_name = _unquote(match.group(1))
        # match.end() points right after the opening '('
        # Re-position to the '(' itself so _extract_paren_body can start at depth=0
        open_paren_pos = match.end() - 1
        body = _extract_paren_body(sql_text, open_paren_pos)
        if body is not None:
            table = _parse_table_body(table_name, body)
            tables[table_name] = table

    return SchemaModel(tables=tables)


def _extract_paren_body(text: str, start: int) -> Optional[str]:
    """Return text between the balanced outer parentheses starting at `start`."""
    depth = 0
    body_start: Optional[int] = None
    i = start
    while i < len(text):
        ch = text[i]
        if ch == "(":
            depth += 1
            if depth == 1:
                body_start = i + 1
        elif ch == ")":
            depth -= 1
            if depth == 0 and body_start is not None:
                return text[body_start:i]
        i += 1
    return None


# ──────────────────────────────────────────────
# Internal helpers
# ──────────────────────────────────────────────

def _strip_comments(sql: str) -> str:
    sql = re.sub(r"--[^\n]*", "", sql)
    sql = re.sub(r"/\*.*?\*/", "", sql, flags=re.DOTALL)
    return sql


def _unquote(name: str) -> str:
    return name.strip("`\"[]'")


def _split_defs(body: str) -> list[str]:
    """Split table body into individual column/constraint definitions,
    respecting nested parentheses (e.g. ENUM, DECIMAL(10,2))."""
    parts: list[str] = []
    depth = 0
    buf: list[str] = []

    for ch in body:
        if ch == "(":
            depth += 1
            buf.append(ch)
        elif ch == ")":
            depth -= 1
            buf.append(ch)
        elif ch == "," and depth == 0:
            line = "".join(buf).strip()
            if line:
                parts.append(line)
            buf = []
        else:
            buf.append(ch)

    last = "".join(buf).strip()
    if last:
        parts.append(last)

    return parts


def _parse_table_body(table_name: str, body: str) -> TableModel:
    columns: list[ColumnModel] = []
    foreign_keys: list[ForeignKeyModel] = []
    pk_columns: set[str] = set()
    unique_columns: set[str] = set()

    for line in _split_defs(body):
        upper = line.upper().lstrip()

        if re.match(r"PRIMARY\s+KEY", upper):
            pk_columns.update(_parse_col_list(line))

        elif re.match(r"UNIQUE\s+(?:KEY|INDEX)?", upper):
            unique_columns.update(_parse_col_list(line))

        elif re.match(r"(?:CONSTRAINT\s+\S+\s+)?FOREIGN\s+KEY", upper):
            fk = _parse_fk(line)
            if fk:
                foreign_keys.append(fk)

        elif re.match(r"(?:KEY|INDEX)\s", upper):
            # Regular index — skip
            pass

        elif re.match(r"CONSTRAINT\s+\S+\s+PRIMARY\s+KEY", upper):
            pk_columns.update(_parse_col_list(line))

        elif re.match(r"CONSTRAINT\s+\S+\s+UNIQUE", upper):
            unique_columns.update(_parse_col_list(line))

        else:
            col = _parse_column(line)
            if col:
                columns.append(col)

    # Apply table-level constraints back onto columns
    for col in columns:
        if col.name in pk_columns:
            col.is_pk = True
            col.nullable = False
        if col.name in unique_columns:
            col.is_unique = True

    # Attach FK metadata to columns
    for fk in foreign_keys:
        for col in columns:
            if col.name == fk.column:
                col.is_fk = True
                col.fk_ref_table = fk.ref_table
                col.fk_ref_column = fk.ref_column

    return TableModel(
        name=table_name,
        columns=columns,
        primary_key=[c.name for c in columns if c.is_pk] or list(pk_columns),
        foreign_keys=foreign_keys,
        unique_constraints=list(unique_columns),
    )


def _parse_column(line: str) -> Optional[ColumnModel]:
    """Parse a single column definition line."""
    line = line.strip()
    # Must start with a name token (quoted or plain)
    m = re.match(r"^([`\"\[\]\w]+)\s+(\w+(?:\s*\([^)]*\))?)", line, re.IGNORECASE)
    if not m:
        return None

    col_name = _unquote(m.group(1))
    raw_type_str = m.group(2).strip()
    rest = line[m.end():]

    # Parse base type and args
    tm = re.match(r"(\w+)\s*(?:\(([^)]*)\))?", raw_type_str, re.IGNORECASE)
    if not tm:
        return None

    base_type = tm.group(1).lower()
    type_args = tm.group(2)

    length: Optional[int] = None
    precision: Optional[int] = None
    scale: Optional[int] = None

    if type_args:
        args = [a.strip().strip("'\"") for a in type_args.split(",")]
        try:
            if len(args) == 1 and args[0].isdigit():
                length = int(args[0])
            elif len(args) == 2:
                precision = int(args[0]) if args[0].isdigit() else None
                scale = int(args[1]) if args[1].isdigit() else None
        except ValueError:
            pass

    is_unsigned = bool(re.search(r"\bUNSIGNED\b", rest, re.IGNORECASE))
    is_pk = bool(re.search(r"\bPRIMARY\s+KEY\b", rest, re.IGNORECASE))
    is_unique = bool(re.search(r"\bUNIQUE\b", rest, re.IGNORECASE))
    is_auto_increment = bool(re.search(r"\bAUTO_INCREMENT\b", rest, re.IGNORECASE))
    nullable = not bool(re.search(r"\bNOT\s+NULL\b", rest, re.IGNORECASE))

    default: Optional[str] = None
    dm = re.search(r"\bDEFAULT\s+(\'[^\']*\'|\S+)", rest, re.IGNORECASE)
    if dm:
        default = dm.group(1).strip("'\"")

    return ColumnModel(
        name=col_name,
        sql_type=base_type,
        nullable=False if is_pk else nullable,
        default=default,
        is_pk=is_pk,
        is_fk=False,
        fk_ref_table=None,
        fk_ref_column=None,
        length=length,
        precision=precision,
        scale=scale,
        is_unsigned=is_unsigned,
        is_auto_increment=is_auto_increment,
        is_unique=is_unique,
    )


def _parse_col_list(line: str) -> list[str]:
    """Extract column names from something like PRIMARY KEY (`col1`, `col2`)."""
    m = re.search(r"\(([^)]+)\)", line)
    if m:
        return [_unquote(c.strip()) for c in m.group(1).split(",")]
    return []


def _parse_fk(line: str) -> Optional[ForeignKeyModel]:
    """FOREIGN KEY (`col`) REFERENCES `table` (`ref_col`)"""
    m = re.search(
        r"FOREIGN\s+KEY\s*\(([^)]+)\)\s+REFERENCES\s+([`\"\[\]\w]+)\s*\(([^)]+)\)",
        line,
        re.IGNORECASE,
    )
    if not m:
        return None

    col = _unquote(m.group(1).strip().split(",")[0])
    ref_table = _unquote(m.group(2).strip())
    ref_col = _unquote(m.group(3).strip().split(",")[0])

    return ForeignKeyModel(column=col, ref_table=ref_table, ref_column=ref_col)
