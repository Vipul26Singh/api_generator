# microservice-generator

Generate fully functional **Spring Boot microservices** from a SQL schema and a YAML config — no boilerplate, no copy-paste.

Point it at your `schema.sql`, tell it which tables belong to which service, run one command, and get production-ready Maven projects complete with JPA entities, repositories, services, REST controllers, `Dockerfile`, and a root `docker-compose.yml`.

---

## How it works

```
schema.sql  ──┐
              ├──▶  msgen generate  ──▶  output/
services.yml ──┘                         ├── inventory-service/
                                         │   ├── pom.xml
                                         │   ├── Dockerfile
                                         │   └── src/main/java/.../
                                         │       ├── entity/
                                         │       ├── repository/
                                         │       ├── service/
                                         │       └── controller/
                                         ├── event-service/
                                         ├── auth-service/
                                         └── docker-compose.yml
```

---

## Quick start

```bash
pip install -e .

msgen generate \
  --schema examples/schema.sql \
  --config examples/services.yml \
  --output ./output
```

Then build and run everything:

```bash
cd output
docker compose up --build
```

Each service exposes:
- REST API at `http://localhost:{port}/api/{resource}`
- Swagger UI at `http://localhost:{port}/swagger-ui.html`

---

## Installation

```bash
git clone <repo>
cd microservice-generator
pip install -e .
```

**Requirements:** Python 3.10+, pip

---

## CLI reference

```
msgen generate [OPTIONS]

  --schema  / -s   Path to SQL DDL file         (required)
  --config  / -c   Path to services YAML file   (required)
  --output  / -o   Output directory             (default: ./output)
  --generator / -g Generator backend            (default: spring-boot)

msgen list-generators
  List all available generator backends.
```

---

## Schema file (`schema.sql`)

Standard `CREATE TABLE` SQL — MySQL dialect. The parser handles:

- Inline column constraints (`PRIMARY KEY`, `NOT NULL`, `UNIQUE`, `AUTO_INCREMENT`, `DEFAULT`)
- Table-level constraints (`PRIMARY KEY (...)`, `UNIQUE KEY ...`, `FOREIGN KEY ... REFERENCES`)
- Backtick-quoted names
- `UNSIGNED` integer columns
- `TINYINT(1)` → `Boolean` mapping
- `TEXT` / `BLOB` → `@Lob`
- `DECIMAL(p,s)` → `BigDecimal` with precision/scale annotations
- `TIMESTAMP` / `DATETIME` → `LocalDateTime`

---

## Services config (`services.yml`)

```yaml
global:
  group_id: com.example        # Maven groupId
  base_package: com.example    # Java base package
  java_version: "17"
  spring_boot_version: "3.2.0"

services:
  - name: inventory-service
    port: 8081
    tables:
      - equipments
      - equipment_category
    database:
      host: inventory-db
      port: 3306
      name: inventory_db
      username: inv_user
      password: inv_pass

  - name: event-service
    port: 8082
    tables:
      - events
    database:
      host: event-db
      port: 3306
      name: event_db
      username: evt_user
      password: evt_pass
```

Rules:
- Each table can only appear in **one** service
- Each service must have a unique `name` and `port`
- Foreign keys between tables in the **same service** → `@ManyToOne @JoinColumn`
- Foreign keys pointing to a **different service** → plain `Long` field + comment (cross-service joins are an anti-pattern)

---

## What gets generated per service

### Maven project layout

```
{service-name}/
├── pom.xml
├── Dockerfile
└── src/main/
    ├── java/com/example/{servicename}/
    │   ├── {Name}Application.java
    │   ├── entity/
    │   │   └── {TableName}.java          ← @Entity with Lombok
    │   ├── repository/
    │   │   └── {TableName}Repository.java ← JpaRepository<Entity, PkType>
    │   ├── service/
    │   │   └── {TableName}Service.java   ← findAll, findById, save, deleteById
    │   └── controller/
    │       └── {TableName}Controller.java ← GET/POST/PUT/DELETE REST endpoints
    └── resources/
        └── application.yml
```

### REST endpoints per entity

| Method | Path | Description |
|--------|------|-------------|
| GET | `/api/{resource}` | List all |
| GET | `/api/{resource}/{id}` | Get by ID |
| POST | `/api/{resource}` | Create |
| PUT | `/api/{resource}/{id}` | Update |
| DELETE | `/api/{resource}/{id}` | Delete |

### Dependencies in every `pom.xml`

- `spring-boot-starter-web`
- `spring-boot-starter-data-jpa`
- `spring-boot-starter-validation`
- `mysql-connector-j`
- `lombok`
- `springdoc-openapi-starter-webmvc-ui` (Swagger UI)

---

## SQL type → Java type mapping

| SQL | Java | Notes |
|-----|------|-------|
| `BIGINT` | `Long` | |
| `INT` / `INTEGER` | `Integer` | |
| `INT UNSIGNED` | `Long` | Unsigned promotion |
| `TINYINT(1)` | `Boolean` | Special-cased |
| `DECIMAL(p,s)` | `BigDecimal` | `@Column(precision,scale)` |
| `VARCHAR(n)` | `String` | `@Column(length=n)` |
| `TEXT` / `LONGTEXT` | `String` | `@Lob` |
| `DATETIME` / `TIMESTAMP` | `LocalDateTime` | |
| `DATE` | `LocalDate` | |
| `BLOB` | `byte[]` | `@Lob` |
| `JSON` | `String` | `columnDefinition="JSON"` |
| Unknown | `String` | Warning printed |

---

## Architecture

```
microservice_generator/
├── cli.py                          # Click CLI entry point
├── config/
│   └── loader.py                   # YAML config loader + validation
├── parser/
│   ├── models.py                   # SchemaModel, TableModel, ColumnModel (framework-agnostic)
│   └── ddl_parser.py               # Regex-based MySQL DDL parser
├── generators/
│   ├── base.py                     # Abstract BaseGenerator (Jinja2 rendering + file writing)
│   ├── registry.py                 # Generator name → class registry
│   └── springboot/
│       ├── generator.py            # SpringBootGenerator — orchestrates all output
│       ├── type_mapper.py          # SQL type → JavaTypeInfo mapping
│       └── templates/              # Jinja2 templates (.j2)
└── utils/
    └── naming.py                   # snake_case ↔ PascalCase ↔ kebab-case helpers
```

### Adding a new generator backend

1. Create `generators/{yourtech}/generator.py` subclassing `BaseGenerator`
2. Implement `generate()` and `template_dir`
3. Add your Jinja2 templates in `generators/{yourtech}/templates/`
4. Register it in `generators/registry.py`

That's it — the CLI, parser, and config loader are completely reusable.

---

## Dependencies

```
click>=8.1
pyyaml>=6.0
jinja2>=3.1
```

No Java required to run the generator — only to build the output projects.
