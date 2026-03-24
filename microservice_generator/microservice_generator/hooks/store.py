"""
SQLite-backed store for pre/post hook bodies.

Hooks are keyed by (service_name, entity_name, hook_type).
Storing them here means regenerating the service preserves all
custom transformation logic without manual merging.

Hook types:
    before_fetch_all — runs before repository.findAll()
    after_fetch_all  — runs after  repository.findAll()
    before_fetch     — runs before repository.findById()
    after_fetch      — runs after  repository.findById()
    before_save      — runs before repository.save() on create OR update
    after_save       — runs after  repository.save()
    before_delete    — runs before repository.deleteById()
    after_delete     — runs after  repository.deleteById()
"""

import sqlite3
from dataclasses import dataclass
from pathlib import Path
from typing import Optional

DEFAULT_DB_PATH = Path.home() / ".msgen" / "hooks.db"

VALID_HOOK_TYPES = {
    "before_fetch_all",
    "after_fetch_all",
    "before_fetch",
    "after_fetch",
    "before_save",
    "after_save",
    "before_delete",
    "after_delete",
}


@dataclass
class HookRecord:
    id: int
    service_name: str
    entity_name: str
    hook_type: str
    java_code: str
    created_at: str
    updated_at: str


class HooksStore:
    def __init__(self, db_path: Path = DEFAULT_DB_PATH) -> None:
        self.db_path = db_path
        self.db_path.parent.mkdir(parents=True, exist_ok=True)
        self._init_db()

    # ── Setup ─────────────────────────────────────────────────────────────

    def _init_db(self) -> None:
        with self._connect() as conn:
            conn.execute("""
                CREATE TABLE IF NOT EXISTS hooks (
                    id           INTEGER PRIMARY KEY AUTOINCREMENT,
                    service_name TEXT    NOT NULL,
                    entity_name  TEXT    NOT NULL,
                    hook_type    TEXT    NOT NULL,
                    java_code    TEXT    NOT NULL,
                    created_at   TEXT    NOT NULL DEFAULT (datetime('now')),
                    updated_at   TEXT    NOT NULL DEFAULT (datetime('now')),
                    UNIQUE (service_name, entity_name, hook_type)
                )
            """)

    def _connect(self) -> sqlite3.Connection:
        conn = sqlite3.connect(self.db_path)
        conn.row_factory = sqlite3.Row
        return conn

    # ── Write ─────────────────────────────────────────────────────────────

    def register(
        self,
        service_name: str,
        entity_name: str,
        hook_type: str,
        java_code: str,
    ) -> None:
        """Insert or replace a hook body."""
        if hook_type not in VALID_HOOK_TYPES:
            raise ValueError(
                f"Invalid hook_type '{hook_type}'. "
                f"Must be one of: {', '.join(sorted(VALID_HOOK_TYPES))}"
            )
        with self._connect() as conn:
            conn.execute(
                """
                INSERT INTO hooks (service_name, entity_name, hook_type, java_code)
                VALUES (?, ?, ?, ?)
                ON CONFLICT (service_name, entity_name, hook_type)
                DO UPDATE SET
                    java_code  = excluded.java_code,
                    updated_at = datetime('now')
                """,
                (service_name, entity_name, hook_type, java_code),
            )

    def remove(
        self,
        service_name: str,
        entity_name: str,
        hook_type: str,
    ) -> int:
        """Delete a hook. Returns number of rows deleted."""
        with self._connect() as conn:
            cur = conn.execute(
                "DELETE FROM hooks WHERE service_name=? AND entity_name=? AND hook_type=?",
                (service_name, entity_name, hook_type),
            )
            return cur.rowcount

    # ── Read ──────────────────────────────────────────────────────────────

    def list_hooks(
        self,
        service_name: Optional[str] = None,
        entity_name: Optional[str] = None,
    ) -> list[HookRecord]:
        query = "SELECT * FROM hooks WHERE 1=1"
        params: list = []
        if service_name:
            query += " AND service_name = ?"
            params.append(service_name)
        if entity_name:
            query += " AND entity_name = ?"
            params.append(entity_name)
        query += " ORDER BY service_name, entity_name, hook_type"
        with self._connect() as conn:
            rows = conn.execute(query, params).fetchall()
        return [HookRecord(**dict(r)) for r in rows]

    def get_for_entity(
        self, service_name: str, entity_name: str
    ) -> dict[str, str]:
        """Return {hook_type: java_code} for one entity."""
        with self._connect() as conn:
            rows = conn.execute(
                "SELECT hook_type, java_code FROM hooks "
                "WHERE service_name=? AND entity_name=?",
                (service_name, entity_name),
            ).fetchall()
        return {r["hook_type"]: r["java_code"] for r in rows}
