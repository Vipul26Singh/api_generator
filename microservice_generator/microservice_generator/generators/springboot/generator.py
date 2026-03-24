from pathlib import Path
from typing import Optional

from ..base import BaseGenerator
from ...config.loader import GeneratorConfig, ServiceConfig
from ...parser.models import SchemaModel, TableModel, ColumnModel
from ...hooks.store import HooksStore, DEFAULT_DB_PATH
from ...utils.naming import (
    to_pascal_case,
    to_camel_case,
    to_kebab_case,
    to_package_path,
    to_app_class_name,
    to_package_suffix,
    table_to_class_name,
    table_to_url_path,
)
from .type_mapper import map_column, collect_imports, JavaTypeInfo


class SpringBootGenerator(BaseGenerator):

    def __init__(self, *args, hooks_db: Optional[Path] = None, **kwargs) -> None:
        super().__init__(*args, **kwargs)
        self._hooks_store = HooksStore(hooks_db or DEFAULT_DB_PATH)

    @property
    def template_dir(self) -> Path:
        return Path(__file__).parent / "templates"

    def generate(self) -> None:
        gs = self.config.global_settings

        all_services = self.config.services

        for service in all_services:
            tables_in_service = set(service.tables)
            print(f"\n[spring-boot] Generating '{service.name}'...")
            self._generate_service(service, tables_in_service, gs)

        # Root docker-compose spanning all services
        self._generate_docker_compose(all_services)
        print("\n[spring-boot] Done.")

    # ── Service-level generation ──────────────────────────────────────────

    def _generate_service(self, svc: ServiceConfig, tables_in_service: set[str], gs) -> None:
        pkg_suffix = to_package_suffix(svc.name)
        package = f"{gs.base_package}.{pkg_suffix}"
        app_class = to_app_class_name(svc.name)
        svc_root = self.output_dir / svc.name

        # pom.xml
        self._write(
            svc_root / "pom.xml",
            self._render("pom.xml.j2", {
                "group_id": gs.group_id,
                "artifact_id": svc.name,
                "service_name": svc.name,
                "java_version": gs.java_version,
                "spring_boot_version": gs.spring_boot_version,
            }),
        )

        # Dockerfile
        self._write(
            svc_root / "Dockerfile",
            self._render("Dockerfile.j2", {
                "java_version": gs.java_version,
                "port": svc.port,
            }),
        )

        # application.yml
        self._write(
            svc_root / "src/main/resources/application.yml",
            self._render("application.yml.j2", {
                "service_name": svc.name,
                "port": svc.port,
                "db": svc.database,
            }),
        )

        # Main Application class
        java_src = svc_root / "src/main/java" / to_package_path(package)
        self._write(
            java_src / f"{app_class}Application.java",
            self._render("Application.java.j2", {
                "package": package,
                "app_class": app_class,
                "service_name": svc.name,
            }),
        )

        # Precompute relationship metadata for the whole service before
        # generating individual table artifacts (OneToMany / ManyToMany
        # inverse sides require knowing all tables first).
        service_tables = [
            self.schema.tables[t] for t in svc.tables if t in self.schema.tables
        ]
        junction_tables, inverse_rels = self._build_service_relationships(
            service_tables, tables_in_service
        )

        # Per-table artifacts (skip pure junction tables — managed by @JoinTable)
        for table_name in svc.tables:
            table = self.schema.tables.get(table_name)
            if table is None:
                print(f"  [WARN] Table '{table_name}' not found in schema — skipping")
                continue
            if table_name in junction_tables:
                print(f"  [INFO] '{table_name}' is a junction table — skipping (managed via @ManyToMany @JoinTable)")
                continue
            self._generate_table_artifacts(
                table,
                svc.name,
                package,
                java_src,
                tables_in_service,
                inverse_rels.get(table_name, []),
            )

    def _generate_table_artifacts(
        self,
        table: TableModel,
        svc_name: str,
        package: str,
        java_src: Path,
        tables_in_service: set[str],
        inverse_relationships: list[dict],
    ) -> None:
        class_name = table_to_class_name(table.name)
        url_path = table_to_url_path(table.name)
        pk_col = next((c for c in table.columns if c.is_pk), None)
        pk_java_type = map_column(pk_col).java_type if pk_col else "Long"
        pk_field = to_camel_case(pk_col.name) if pk_col else "id"
        pk_field_pascal = to_pascal_case(pk_col.name) if pk_col else "Id"

        columns_ctx = self._build_columns_ctx(table.columns, tables_in_service)

        # Merge type-mapper imports + relationship imports
        extra_imports = collect_imports(table.columns)
        for rel in inverse_relationships:
            extra_imports = list(dict.fromkeys(extra_imports + rel.get("imports", [])))

        ctx = {
            "package": package,
            "class_name": class_name,
            "table_name": table.name,
            "url_path": url_path,
            "pk_java_type": pk_java_type,
            "pk_field": pk_field,
            "pk_field_pascal": pk_field_pascal,
            "columns": columns_ctx,
            "imports": extra_imports,
            "relationships": inverse_relationships,
        }

        # Load any stored hooks from the DB for this entity
        stored_hooks = self._hooks_store.get_for_entity(svc_name, class_name)
        hooks_ctx = {k: stored_hooks.get(k) for k in (
            "before_fetch_all", "after_fetch_all",
            "before_fetch", "after_fetch",
            "before_save", "after_save",
            "before_delete", "after_delete",
        )}

        self._write(java_src / "entity" / f"{class_name}.java",
                    self._render("Entity.java.j2", ctx))
        self._write(java_src / "repository" / f"{class_name}Repository.java",
                    self._render("Repository.java.j2", ctx))
        self._write(java_src / "service" / f"{class_name}Service.java",
                    self._render("Service.java.j2", ctx))
        self._write(java_src / "controller" / f"{class_name}Controller.java",
                    self._render("Controller.java.j2", ctx))
        self._write(java_src / "hooks" / f"{class_name}Hooks.java",
                    self._render("Hooks.java.j2", ctx))
        self._write(java_src / "hooks" / f"Default{class_name}Hooks.java",
                    self._render("DefaultHooks.java.j2", {**ctx, "hooks": hooks_ctx}))

    # ── Relationship detection ────────────────────────────────────────────

    def _is_junction_table(
        self, table: TableModel, tables_in_service: set[str]
    ) -> bool:
        """
        A table is a pure junction/pivot table when it has exactly 2 FK columns
        both pointing to tables within the same service, and no other non-PK data
        columns. JPA manages these via @ManyToMany @JoinTable — no entity needed.
        """
        fk_cols = [
            c for c in table.columns
            if c.is_fk and c.fk_ref_table in tables_in_service
        ]
        data_cols = [c for c in table.columns if not c.is_pk and not c.is_fk]
        return len(fk_cols) == 2 and len(data_cols) == 0

    def _build_service_relationships(
        self,
        service_tables: list[TableModel],
        tables_in_service: set[str],
    ) -> tuple[set[str], dict[str, list[dict]]]:
        """
        Pre-compute all relationship metadata for the service.

        Returns:
            junction_tables  — set of table names that are pure M2M join tables
            inverse_rels     — {table_name: [relationship_dict, ...]}
                               Extra fields to inject into each entity (the
                               "other side" of @OneToMany and @ManyToMany).
        """
        junction_tables: set[str] = set()
        inverse_rels: dict[str, list[dict]] = {t.name: [] for t in service_tables}

        # ── Pass 1: identify junction tables ─────────────────────────────
        for table in service_tables:
            if self._is_junction_table(table, tables_in_service):
                junction_tables.add(table.name)

        # ── Pass 2: build inverse sides ───────────────────────────────────
        for table in service_tables:
            if table.name in junction_tables:
                # ManyToMany — inject into BOTH referenced entities
                fk_cols = [
                    c for c in table.columns
                    if c.is_fk and c.fk_ref_table in tables_in_service
                ]
                # fk_cols[0] → owning side entity
                # fk_cols[1] → inverse side entity
                fk_a, fk_b = fk_cols[0], fk_cols[1]
                ref_a, ref_b = fk_a.fk_ref_table, fk_b.fk_ref_table
                class_a = table_to_class_name(ref_a)
                class_b = table_to_class_name(ref_b)

                # Field name on A = camelCase of ref_b's table name
                field_on_a = to_camel_case(ref_b)
                # Field name on B = camelCase of ref_a's table name
                field_on_b = to_camel_case(ref_a)

                # Owning side (A) — carries @JoinTable
                owning_annotations = [
                    "@ManyToMany",
                    "@JoinTable(",
                    f'    name = "{table.name}",',
                    f'    joinColumns = @JoinColumn(name = "{fk_a.name}"),',
                    f'    inverseJoinColumns = @JoinColumn(name = "{fk_b.name}")',
                    ")",
                ]
                if ref_a in inverse_rels:
                    inverse_rels[ref_a].append({
                        "annotation_lines": owning_annotations,
                        "field_name": field_on_a,
                        "java_type": f"Set<{class_b}>",
                        "javadoc": f"Many-to-many relationship to {{@link {class_b}}} via the {{@code {table.name}}} join table.",
                        "imports": [
                            "jakarta.persistence.ManyToMany",
                            "jakarta.persistence.JoinTable",
                            "jakarta.persistence.JoinColumn",
                            "java.util.Set",
                        ],
                    })

                # Inverse side (B) — uses mappedBy
                if ref_b in inverse_rels:
                    inverse_rels[ref_b].append({
                        "annotation_lines": [f'@ManyToMany(mappedBy = "{field_on_a}")'],
                        "field_name": field_on_b,
                        "java_type": f"Set<{class_a}>",
                        "javadoc": f"Many-to-many relationship to {{@link {class_a}}} (inverse side).",
                        "imports": [
                            "jakarta.persistence.ManyToMany",
                            "java.util.Set",
                        ],
                    })

            else:
                # Check outgoing FKs — each one generates an inverse on the parent
                for col in table.columns:
                    if not col.is_fk or col.fk_ref_table not in tables_in_service:
                        continue
                    if col.fk_ref_table not in inverse_rels:
                        continue

                    child_class = table_to_class_name(table.name)
                    # The field name used on the child side for this FK
                    mapped_by_field = to_camel_case(
                        col.name[:-3] if col.name.endswith("_id") else col.name
                    )

                    if col.is_unique:
                        # @OneToOne — FK is unique, so at most one child per parent
                        inverse_rels[col.fk_ref_table].append({
                            "annotation_lines": [
                                f'@OneToOne(mappedBy = "{mapped_by_field}")',
                            ],
                            "field_name": to_camel_case(table.name),
                            "java_type": child_class,
                            "javadoc": f"One-to-one relationship to {{@link {child_class}}}.",
                            "imports": ["jakarta.persistence.OneToOne"],
                        })
                    else:
                        # @OneToMany — standard FK, multiple children per parent
                        inverse_rels[col.fk_ref_table].append({
                            "annotation_lines": [
                                f'@OneToMany(mappedBy = "{mapped_by_field}")',
                            ],
                            "field_name": to_camel_case(table.name),
                            "java_type": f"List<{child_class}>",
                            "javadoc": f"One-to-many relationship to {{@link {child_class}}}.",
                            "imports": [
                                "jakarta.persistence.OneToMany",
                                "java.util.List",
                            ],
                        })

        return junction_tables, inverse_rels

    # ── Column context builder ────────────────────────────────────────────

    def _build_columns_ctx(
        self, columns: list[ColumnModel], tables_in_service: set[str]
    ) -> list[dict]:
        ctx_cols = []
        for col in columns:
            info: JavaTypeInfo = map_column(col)

            # Determine if this FK points to a table in the same service
            in_service_fk = (
                col.is_fk
                and col.fk_ref_table is not None
                and col.fk_ref_table in tables_in_service
            )

            if in_service_fk:
                ref_class = table_to_class_name(col.fk_ref_table)
                field_name = to_camel_case(
                    col.name[:-3] if col.name.endswith("_id") else col.name
                )
                if col.is_unique:
                    # @OneToOne — this FK column has a UNIQUE constraint
                    annotations = [
                        "@OneToOne",
                        f'@JoinColumn(name = "{col.name}")',
                    ]
                else:
                    # @ManyToOne — standard FK
                    annotations = [
                        "@ManyToOne",
                        f'@JoinColumn(name = "{col.name}")',
                    ]
                java_type = ref_class
                extra_imports_for_col = [
                    "jakarta.persistence.OneToOne" if col.is_unique else "jakarta.persistence.ManyToOne",
                    "jakarta.persistence.JoinColumn",
                ]
            else:
                annotations = list(info.jpa_annotations)
                field_name = to_camel_case(col.name)
                java_type = info.java_type

                # Build @Column annotation for column-level settings
                col_ann_parts = []
                if col.name != field_name:          # column name differs from field
                    col_ann_parts.append(f'name = "{col.name}"')
                if not col.nullable and not col.is_pk:
                    col_ann_parts.append("nullable = false")
                if col.is_unique:
                    col_ann_parts.append("unique = true")
                if info.col_def_override:
                    col_ann_parts.append(f'columnDefinition = "{info.col_def_override}"')

                if col_ann_parts and not any("@Column" in a for a in annotations):
                    annotations.append(f"@Column({', '.join(col_ann_parts)})")

                extra_imports_for_col = []
                if in_service_fk is False and col.is_fk:
                    # Cross-service FK — emit as plain Long with comment
                    java_type = "Long"
                    extra_imports_for_col = []

            ctx_cols.append({
                "name": col.name,
                "field_name": field_name,
                "java_type": java_type,
                "is_pk": col.is_pk,
                "is_fk": col.is_fk,
                "in_service_fk": in_service_fk,
                "fk_ref_table": col.fk_ref_table,
                "nullable": col.nullable,
                "annotations": annotations,
                "is_auto_increment": col.is_auto_increment,
                "cross_service_fk_comment": (
                    f"// Cross-service reference → {col.fk_ref_table}"
                    if col.is_fk and not in_service_fk
                    else None
                ),
            })

        return ctx_cols

    # ── docker-compose ────────────────────────────────────────────────────

    def _generate_docker_compose(self, services) -> None:
        self._write(
            self.output_dir / "docker-compose.yml",
            self._render("docker-compose.yml.j2", {"services": services}),
        )
