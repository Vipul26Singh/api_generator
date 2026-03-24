from dataclasses import dataclass, field
from typing import Optional

from ...parser.models import ColumnModel


@dataclass
class JavaTypeInfo:
    java_type: str
    import_path: Optional[str] = None        # None for java.lang types (String, Integer, etc.)
    jpa_annotations: list[str] = field(default_factory=list)
    col_def_override: Optional[str] = None   # passed to @Column(columnDefinition=...)


# ── Core mapping ─────────────────────────────────────────────────────────────

# Full-string overrides checked first (lowercase normalized)
_FULL_MATCH: dict[str, JavaTypeInfo] = {
    "tinyint(1)": JavaTypeInfo("Boolean"),
    "bit(1)":     JavaTypeInfo("Boolean"),
}

# Base-type prefix lookup
_BASE_MAP: dict[str, JavaTypeInfo] = {
    # Integers
    "tinyint":   JavaTypeInfo("Integer"),
    "smallint":  JavaTypeInfo("Integer"),
    "mediumint": JavaTypeInfo("Integer"),
    "int":       JavaTypeInfo("Integer"),
    "integer":   JavaTypeInfo("Integer"),
    "bigint":    JavaTypeInfo("Long"),
    "serial":    JavaTypeInfo("Long"),
    "bigserial": JavaTypeInfo("Long"),
    # Boolean
    "boolean":   JavaTypeInfo("Boolean"),
    "bool":      JavaTypeInfo("Boolean"),
    "bit":       JavaTypeInfo("Boolean"),
    # Floating point
    "float":     JavaTypeInfo("Float"),
    "double":    JavaTypeInfo("Double"),
    "real":      JavaTypeInfo("Double"),
    # Fixed precision
    "decimal":   JavaTypeInfo("BigDecimal", "java.math.BigDecimal"),
    "numeric":   JavaTypeInfo("BigDecimal", "java.math.BigDecimal"),
    # Strings
    "char":      JavaTypeInfo("String"),
    "varchar":   JavaTypeInfo("String"),
    "tinytext":  JavaTypeInfo("String"),
    "text":      JavaTypeInfo("String", jpa_annotations=["@Lob"]),
    "mediumtext":JavaTypeInfo("String", jpa_annotations=["@Lob"]),
    "longtext":  JavaTypeInfo("String", jpa_annotations=["@Lob"]),
    "clob":      JavaTypeInfo("String", jpa_annotations=["@Lob"]),
    "enum":      JavaTypeInfo("String"),
    "set":       JavaTypeInfo("String"),
    # Temporal
    "date":      JavaTypeInfo("LocalDate",     "java.time.LocalDate"),
    "time":      JavaTypeInfo("LocalTime",     "java.time.LocalTime"),
    "datetime":  JavaTypeInfo("LocalDateTime", "java.time.LocalDateTime"),
    "timestamp": JavaTypeInfo(
        "LocalDateTime", "java.time.LocalDateTime",
        col_def_override="TIMESTAMP",
    ),
    "year":      JavaTypeInfo("Integer"),
    # Binary
    "blob":      JavaTypeInfo("byte[]", jpa_annotations=["@Lob"]),
    "mediumblob":JavaTypeInfo("byte[]", jpa_annotations=["@Lob"]),
    "longblob":  JavaTypeInfo("byte[]", jpa_annotations=["@Lob"]),
    "binary":    JavaTypeInfo("byte[]"),
    "varbinary": JavaTypeInfo("byte[]"),
    # Special
    "json":      JavaTypeInfo("String", col_def_override="JSON"),
    "uuid":      JavaTypeInfo("UUID", "java.util.UUID"),
}


def map_column(col: ColumnModel) -> JavaTypeInfo:
    """Return Java type info for the given column, applying unsigned promotion."""
    raw = col.sql_type.lower().strip()

    # tinyint(1) -> Boolean special case
    full_key = raw
    if col.length is not None:
        full_key = f"{raw}({col.length})"
    if full_key in _FULL_MATCH:
        return _FULL_MATCH[full_key]

    info = _BASE_MAP.get(raw)

    if info is None:
        # Unknown type — fall back to String with a warning
        print(f"  [WARN] Unknown SQL type '{raw}' — mapping to String")
        return JavaTypeInfo("String")

    # Unsigned int/smallint/mediumint -> Long (avoid overflow)
    if col.is_unsigned and info.java_type == "Integer":
        info = JavaTypeInfo("Long")

    # BigDecimal: add precision/scale annotations
    if info.java_type == "BigDecimal" and (col.precision or col.scale):
        ann = f'@Column(precision = {col.precision or 10}, scale = {col.scale or 2})'
        info = JavaTypeInfo("BigDecimal", "java.math.BigDecimal", jpa_annotations=[ann])

    # varchar: emit length if specified
    if raw == "varchar" and col.length:
        info = JavaTypeInfo("String", jpa_annotations=[f"@Column(length = {col.length})"])

    return info


def collect_imports(columns: list[ColumnModel]) -> list[str]:
    """Return sorted unique import paths required for the given columns."""
    imports: set[str] = set()
    for col in columns:
        info = map_column(col)
        if info.import_path:
            imports.add(info.import_path)
    return sorted(imports)
