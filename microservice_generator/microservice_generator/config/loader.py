from dataclasses import dataclass, field
from pathlib import Path
from typing import Optional

import yaml


class ConfigValidationError(Exception):
    pass


@dataclass
class DatabaseConfig:
    host: str = "localhost"
    port: int = 3306
    name: str = "service_db"
    username: str = "root"
    password: str = "password"


@dataclass
class ServiceConfig:
    name: str
    port: int
    tables: list[str]
    database: DatabaseConfig = field(default_factory=DatabaseConfig)


@dataclass
class GlobalSettings:
    group_id: str = "com.example"
    base_package: str = "com.example"
    java_version: str = "17"
    spring_boot_version: str = "3.2.0"


@dataclass
class GeneratorConfig:
    global_settings: GlobalSettings
    services: list[ServiceConfig]


def load_config(path: Path) -> GeneratorConfig:
    with open(path) as f:
        raw = yaml.safe_load(f)

    if not isinstance(raw, dict):
        raise ConfigValidationError("Config file must be a YAML mapping")

    global_raw = raw.get("global", {})
    global_settings = GlobalSettings(
        group_id=global_raw.get("group_id", "com.example"),
        base_package=global_raw.get("base_package", global_raw.get("group_id", "com.example")),
        java_version=str(global_raw.get("java_version", "17")),
        spring_boot_version=str(global_raw.get("spring_boot_version", "3.2.0")),
    )

    services_raw = raw.get("services", [])
    if not services_raw:
        raise ConfigValidationError("Config must define at least one service under 'services'")

    services: list[ServiceConfig] = []
    seen_names: set[str] = set()
    seen_ports: set[int] = set()
    all_tables: list[str] = []

    for i, svc in enumerate(services_raw):
        name = svc.get("name")
        if not name:
            raise ConfigValidationError(f"Service #{i + 1} is missing 'name'")
        if name in seen_names:
            raise ConfigValidationError(f"Duplicate service name: '{name}'")
        seen_names.add(name)

        port = svc.get("port")
        if not port:
            raise ConfigValidationError(f"Service '{name}' is missing 'port'")
        if port in seen_ports:
            raise ConfigValidationError(f"Duplicate port {port} in service '{name}'")
        seen_ports.add(port)

        tables = svc.get("tables", [])
        if not tables:
            raise ConfigValidationError(f"Service '{name}' has no tables")

        db_raw = svc.get("database", {})
        db = DatabaseConfig(
            host=db_raw.get("host", "localhost"),
            port=int(db_raw.get("port", 3306)),
            name=db_raw.get("name", f"{name.replace('-', '_')}_db"),
            username=db_raw.get("username", "root"),
            password=db_raw.get("password", "password"),
        )

        services.append(ServiceConfig(name=name, port=port, tables=tables, database=db))
        all_tables.extend(tables)

    # Check for tables claimed by multiple services
    seen_t: set[str] = set()
    for t in all_tables:
        if t in seen_t:
            raise ConfigValidationError(
                f"Table '{t}' is listed in more than one service"
            )
        seen_t.add(t)

    return GeneratorConfig(global_settings=global_settings, services=services)
