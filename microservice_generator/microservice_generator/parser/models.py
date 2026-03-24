from dataclasses import dataclass, field
from typing import Optional


@dataclass
class ForeignKeyModel:
    column: str
    ref_table: str
    ref_column: str


@dataclass
class ColumnModel:
    name: str
    sql_type: str           # normalized base type, e.g. "varchar", "bigint"
    nullable: bool = True
    default: Optional[str] = None
    is_pk: bool = False
    is_fk: bool = False
    fk_ref_table: Optional[str] = None
    fk_ref_column: Optional[str] = None
    length: Optional[int] = None
    precision: Optional[int] = None
    scale: Optional[int] = None
    is_unsigned: bool = False
    is_auto_increment: bool = False
    is_unique: bool = False


@dataclass
class TableModel:
    name: str
    columns: list[ColumnModel] = field(default_factory=list)
    primary_key: list[str] = field(default_factory=list)
    foreign_keys: list[ForeignKeyModel] = field(default_factory=list)
    unique_constraints: list[str] = field(default_factory=list)


@dataclass
class SchemaModel:
    tables: dict[str, TableModel] = field(default_factory=dict)
