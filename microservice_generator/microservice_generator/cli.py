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
