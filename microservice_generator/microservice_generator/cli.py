"""
msgen — microservice generator CLI

Usage:
    msgen generate --schema schema.sql --config services.yml
    msgen generate --schema schema.sql --config services.yml --output ./out --generator spring-boot
    msgen list-generators
"""

import sys
from pathlib import Path

import click

from .config.loader import load_config, ConfigValidationError
from .parser.ddl_parser import parse_ddl
from .generators.registry import get_generator, list_generators
from .hooks.store import HooksStore, VALID_HOOK_TYPES, DEFAULT_DB_PATH


@click.group()
def main():
    """microservice-generator: scaffold microservices from a SQL schema."""


@main.command()
@click.option(
    "--schema", "-s",
    required=True,
    type=click.Path(exists=True, dir_okay=False, path_type=Path),
    help="Path to the SQL DDL file (CREATE TABLE statements).",
)
@click.option(
    "--config", "-c",
    required=True,
    type=click.Path(exists=True, dir_okay=False, path_type=Path),
    help="Path to the services YAML config file.",
)
@click.option(
    "--output", "-o",
    default="./output",
    show_default=True,
    type=click.Path(path_type=Path),
    help="Directory where generated projects will be written.",
)
@click.option(
    "--generator", "-g",
    default="spring-boot",
    show_default=True,
    help="Generator backend to use.",
)
def generate(schema: Path, config: Path, output: Path, generator: str):
    """Generate microservice projects from a SQL schema + services config."""

    # 1. Load config
    click.echo(f"Loading config: {config}")
    try:
        gen_config = load_config(config)
    except ConfigValidationError as e:
        click.secho(f"Config error: {e}", fg="red", err=True)
        sys.exit(1)

    # 2. Parse DDL
    click.echo(f"Parsing schema: {schema}")
    schema_model = parse_ddl(schema.read_text(encoding="utf-8"))

    if not schema_model.tables:
        click.secho("No CREATE TABLE statements found in schema.", fg="red", err=True)
        sys.exit(1)

    click.echo(f"  Found {len(schema_model.tables)} table(s): {', '.join(schema_model.tables)}")

    # 3. Validate: every table in config must exist in schema
    missing = []
    for svc in gen_config.services:
        for t in svc.tables:
            if t not in schema_model.tables:
                missing.append(f"'{t}' (service: {svc.name})")
    if missing:
        click.secho(
            f"Tables listed in config not found in schema:\n  " + "\n  ".join(missing),
            fg="red", err=True,
        )
        sys.exit(1)

    # 4. Run generator
    output.mkdir(parents=True, exist_ok=True)
    try:
        gen_class = get_generator(generator)
    except ValueError as e:
        click.secho(str(e), fg="red", err=True)
        sys.exit(1)

    gen_instance = gen_class(schema=schema_model, config=gen_config, output_dir=output)
    gen_instance.generate()

    click.secho(f"\nGenerated {len(gen_config.services)} service(s) in '{output}'", fg="green")


@main.command("list-generators")
def list_gens():
    """List all available generator backends."""
    click.echo("Available generators:")
    for name in list_generators():
        click.echo(f"  - {name}")


# ── Hooks command group ───────────────────────────────────────────────────────

@main.group()
def hooks():
    """Manage pre/post hooks stored in the local hooks database.

    Hooks are Java code snippets tied to a specific service + entity + lifecycle
    point. They are woven into Default{Entity}Hooks.java on every generate run,
    so custom transformation logic survives schema regeneration.

    \b
    Available hook types:
        before_fetch_all — before repository.findAll()
        after_fetch_all  — after  repository.findAll()
        before_fetch     — before repository.findById()
        after_fetch      — after  repository.findById()
        before_save      — before repository.save()
        after_save       — after  repository.save()
        before_delete    — before repository.deleteById()
        after_delete     — after  repository.deleteById()
    """


@hooks.command("register")
@click.option("--service",  "-s", required=True, help="Service name (e.g. inventory-service)")
@click.option("--entity",   "-e", required=True, help="Entity class name (e.g. Equipment)")
@click.option("--hook-type","-t", required=True,
              type=click.Choice(sorted(VALID_HOOK_TYPES)), help="Hook type")
@click.option("--code",     "-c", required=True, help="Java code body for the hook method")
@click.option("--db", default=None, type=click.Path(path_type=Path),
              help=f"Path to hooks DB (default: {DEFAULT_DB_PATH})")
def hooks_register(service, entity, hook_type, code, db):
    """Register or update a hook body in the local database.

    \b
    Example:
        msgen hooks register \\
            --service inventory-service \\
            --entity Equipment \\
            --hook-type before_save \\
            --code "entity.setName(entity.getName().trim()); return entity;"
    """
    store = HooksStore(db or DEFAULT_DB_PATH)
    store.register(service, entity, hook_type, code)
    click.secho(
        f"Hook registered: {service} / {entity} / {hook_type}", fg="green"
    )
    click.echo("Re-run 'msgen generate' to weave it into the generated code.")


@hooks.command("list")
@click.option("--service", "-s", default=None, help="Filter by service name")
@click.option("--entity",  "-e", default=None, help="Filter by entity name")
@click.option("--db", default=None, type=click.Path(path_type=Path),
              help=f"Path to hooks DB (default: {DEFAULT_DB_PATH})")
def hooks_list(service, entity, db):
    """List registered hooks."""
    store = HooksStore(db or DEFAULT_DB_PATH)
    records = store.list_hooks(service_name=service, entity_name=entity)
    if not records:
        click.echo("No hooks registered.")
        return
    for r in records:
        click.echo(f"\n{'─'*60}")
        click.echo(f"  Service : {r.service_name}")
        click.echo(f"  Entity  : {r.entity_name}")
        click.echo(f"  Type    : {r.hook_type}")
        click.echo(f"  Updated : {r.updated_at}")
        click.echo(f"  Code    :\n    {r.java_code}")
    click.echo(f"\n{'─'*60}")
    click.echo(f"Total: {len(records)} hook(s)")


@hooks.command("remove")
@click.option("--service",  "-s", required=True)
@click.option("--entity",   "-e", required=True)
@click.option("--hook-type","-t", required=True,
              type=click.Choice(sorted(VALID_HOOK_TYPES)))
@click.option("--db", default=None, type=click.Path(path_type=Path))
def hooks_remove(service, entity, hook_type, db):
    """Remove a registered hook."""
    store = HooksStore(db or DEFAULT_DB_PATH)
    deleted = store.remove(service, entity, hook_type)
    if deleted:
        click.secho(f"Removed: {service} / {entity} / {hook_type}", fg="yellow")
    else:
        click.secho("No matching hook found.", fg="red", err=True)
