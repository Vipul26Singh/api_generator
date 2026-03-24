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
                                         │       ├── controller/
                                         │       └── hooks/       ← pre/post hooks
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

msgen hooks register [OPTIONS]

  --service  / -s   Service name               (required)
  --entity   / -e   Entity class name          (required)
  --hook-type/ -t   Hook type (see table above)(required)
  --code     / -c   Java code body             (required)
  --db              Path to hooks DB           (default: ~/.msgen/hooks.db)

msgen hooks list [OPTIONS]

  --service  / -s   Filter by service name
  --entity   / -e   Filter by entity name
  --db              Path to hooks DB

msgen hooks remove [OPTIONS]

  --service  / -s   Service name               (required)
  --entity   / -e   Entity class name          (required)
  --hook-type/ -t   Hook type                  (required)
  --db              Path to hooks DB
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
- Foreign keys between tables in the **same service** → JPA relationship annotations (see below)
- Foreign keys pointing to a **different service** → plain `Long` field + comment (cross-service joins are an anti-pattern)

---

## JPA relationship mapping

The generator detects all four standard JPA relationship types automatically from your SQL DDL — no extra config required. Detection rules are driven entirely by how you define the schema.

### Quick reference

| SQL pattern | JPA annotation | Also generates |
|---|---|---|
| `FOREIGN KEY (col) REFERENCES other_table` | `@ManyToOne @JoinColumn` on child | `@OneToMany(mappedBy=)` on parent |
| `col ... UNIQUE, FOREIGN KEY (col) REFERENCES other_table` | `@OneToOne @JoinColumn` on child | `@OneToOne(mappedBy=)` on parent |
| *(inverse of the above two)* | *(auto-injected on parent entity)* | `List<Child>` / single ref field |
| Pure junction table (2 FKs, no data cols) | `@ManyToMany @JoinTable` on owning side | `@ManyToMany(mappedBy=)` on inverse side; junction table entity skipped |
| Cross-service FK | none — plain `Long` field + comment | — |

---

### Many-to-One

The most common case. A child table has a foreign key to a parent table **in the same service**.

**SQL:**
```sql
CREATE TABLE equipments (
    id                    BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    equipment_category_id BIGINT UNSIGNED,
    -- ...
    PRIMARY KEY (id),
    FOREIGN KEY (equipment_category_id) REFERENCES equipment_category (id)
);
```

**Generated — `Equipment.java` (child, owning side):**
```java
@ManyToOne
@JoinColumn(name = "equipment_category_id")
private EquipmentCategory equipmentCategory;
```

**Generated — `EquipmentCategory.java` (parent, inverse side, auto-injected):**
```java
@OneToMany(mappedBy = "equipmentCategory")
private List<Equipment> equipments;
```

The `_id` suffix is stripped from the column name to form the field name (`equipment_category_id` → `equipmentCategory`).

---

### One-to-One

Triggered when the FK column also carries a `UNIQUE` constraint, meaning at most one child row can reference each parent row.

**SQL:**
```sql
CREATE TABLE user_profiles (
    id      BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,   -- UNIQUE triggers @OneToOne
    bio     TEXT,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);
```

**Generated — `UserProfile.java` (child, owning side):**
```java
@OneToOne
@JoinColumn(name = "user_id")
private User user;
```

**Generated — `User.java` (parent, inverse side, auto-injected):**
```java
@OneToOne(mappedBy = "user")
private UserProfile userProfile;
```

---

### One-to-Many

You never write this annotation manually. It is always **auto-generated on the parent** as the inverse side of a `@ManyToOne` or `@OneToOne` on the child. See the examples above.

The field name on the parent is derived from the child table's name:

| Child table | Field on parent |
|---|---|
| `equipment_checkin` | `equipmentCheckin` |
| `user_profiles` | `userProfiles` |
| `order_items` | `orderItems` |

---

### Many-to-Many

Triggered when the generator detects a **pure junction table** — a table that has exactly **two foreign-key columns** (both pointing to tables in the same service) and **no other data columns** (an auto-increment PK is allowed).

The junction table itself is **not** turned into an entity; JPA manages it entirely via `@JoinTable`.

**SQL:**
```sql
CREATE TABLE users (
    id       BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    -- ...
    PRIMARY KEY (id)
);

CREATE TABLE user_groups (
    id   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
);

-- Pure junction table — no data columns besides the two FKs
CREATE TABLE user_group_members (
    user_id  BIGINT UNSIGNED NOT NULL,
    group_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, group_id),
    FOREIGN KEY (user_id)  REFERENCES users (id),
    FOREIGN KEY (group_id) REFERENCES user_groups (id)
);
```

**Generator output:**
```
[INFO] 'user_group_members' is a junction table — skipping (managed via @ManyToMany @JoinTable)
```

**Generated — `User.java` (owning side — first FK in the junction table):**
```java
@ManyToMany
@JoinTable(
    name = "user_group_members",
    joinColumns = @JoinColumn(name = "user_id"),
    inverseJoinColumns = @JoinColumn(name = "group_id")
)
private Set<UserGroup> userGroups;
```

**Generated — `UserGroup.java` (inverse side):**
```java
@ManyToMany(mappedBy = "userGroups")
private Set<User> users;
```

> **Junction table with extra columns?** If your join table carries additional data (e.g. `assigned_at`, `role`), add at least one non-FK, non-PK column. The generator will treat it as a regular entity with `@ManyToOne` fields on both sides instead.

---

### Cross-service foreign key

When a FK references a table that belongs to a **different service**, the generator intentionally does **not** create a JPA relationship — cross-service joins are a microservices anti-pattern. The column is emitted as a plain `Long` with a comment:

**SQL:**
```sql
-- event_equipment_checkout is in event-service
-- equipments is in inventory-service  ← different service
FOREIGN KEY (equipment_id) REFERENCES equipments (id)
```

**Generated — `EventEquipmentCheckout.java`:**
```java
// Cross-service reference → equipments
private Long equipmentId;
```

Fetch the related resource via its REST API at runtime.

---

### All four types at a glance

```
equipment_category  ◄──(OneToMany)──  equipments  ◄──(OneToMany)──  equipment_checkin
       (parent)        (ManyToOne)►     (parent)     (ManyToOne)►        (child)

users  ◄──(ManyToMany via user_group_members)──►  user_groups

user_profiles  ──(OneToOne)──►  users
  (child, owns FK)               (parent, mappedBy)
```

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
    │   │   └── {TableName}.java               ← @Entity with Lombok + JavaDoc
    │   ├── repository/
    │   │   └── {TableName}Repository.java      ← JpaRepository<Entity, PkType>
    │   ├── service/
    │   │   └── {TableName}Service.java         ← findAll, findById, save, deleteById
    │   ├── controller/
    │   │   └── {TableName}Controller.java      ← GET/POST/PUT/DELETE REST endpoints
    │   └── hooks/
    │       ├── {TableName}Hooks.java           ← lifecycle hook interface
    │       └── Default{TableName}Hooks.java    ← no-op default (@ConditionalOnMissingBean)
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

---

## Pre/post hooks

Every generated entity comes with a lifecycle hook interface that lets you intercept and transform data at any persistence boundary — **without editing generated code**.

### How it works

```
{Entity}Hooks          ← interface (8 lifecycle methods, all with default no-ops)
Default{Entity}Hooks   ← @Component @ConditionalOnMissingBean — auto-registered
{Entity}Service        ← calls hooks.before*()/after*() around every repo call
```

### Lifecycle points

| Hook | When it fires | Signature |
|------|--------------|-----------|
| `beforeFetchAll()` | before `findAll()` | `void` |
| `afterFetchAll(list)` | after `findAll()` | returns `List<Entity>` |
| `beforeFetch(id)` | before `findById()` | `void` |
| `afterFetch(entity)` | after `findById()` | returns `Entity` |
| `beforeSave(entity)` | before `save()` | returns `Entity` |
| `afterSave(entity)` | after `save()` | returns `Entity` |
| `beforeDelete(id)` | before `deleteById()` | `void` |
| `afterDelete(id)` | after `deleteById()` | `void` |

### Option 1 — register a hook via CLI (survives regeneration)

Hook bodies are stored in a local SQLite database (`~/.msgen/hooks.db`). On every `msgen generate` run they are woven into `Default{Entity}Hooks.java` automatically, so schema changes never wipe your logic.

```bash
# register a transformation
msgen hooks register \
  --service inventory-service \
  --entity  Equipment \
  --hook-type before_save \
  --code "entity.setName(entity.getName().trim()); return entity;"

# list all registered hooks
msgen hooks list
msgen hooks list --service inventory-service

# remove a hook
msgen hooks remove \
  --service inventory-service \
  --entity  Equipment \
  --hook-type before_save
```

Result — `DefaultEquipmentHooks.java` after next generate:

```java
@Override
public Equipment beforeSave(Equipment entity) {
    entity.setName(entity.getName().trim()); return entity;
}
```

### Option 2 — custom Spring bean (for complex logic)

Create any `@Component` that implements `{Entity}Hooks`. Spring will inject yours instead of the generated default via `@ConditionalOnMissingBean` — no config needed.

```java
@Component
public class MyEquipmentHooks implements EquipmentHooks {

    @Override
    public Equipment beforeSave(Equipment entity) {
        entity.setName(entity.getName().trim());
        return entity;
    }

    @Override
    public List<Equipment> afterFetchAll(List<Equipment> entities) {
        return entities.stream()
                .filter(Equipment::getIsAvailable)
                .collect(Collectors.toList());
    }
}
```

> **Tip:** use Option 1 for simple field transforms; use Option 2 when you need Spring injection, complex logic, or multiple collaborators.

---

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
├── cli.py                          # Click CLI entry point (generate + hooks commands)
├── config/
│   └── loader.py                   # YAML config loader + validation
├── parser/
│   ├── models.py                   # SchemaModel, TableModel, ColumnModel (framework-agnostic)
│   └── ddl_parser.py               # Regex-based MySQL DDL parser
├── hooks/
│   └── store.py                    # SQLite-backed hook registry (~/.msgen/hooks.db)
├── generators/
│   ├── base.py                     # Abstract BaseGenerator (Jinja2 rendering + file writing)
│   ├── registry.py                 # Generator name → class registry
│   └── springboot/
│       ├── generator.py            # SpringBootGenerator — orchestrates all output
│       ├── type_mapper.py          # SQL type → JavaTypeInfo mapping
│       └── templates/              # Jinja2 templates (.j2)
│           ├── Entity.java.j2
│           ├── Repository.java.j2
│           ├── Service.java.j2
│           ├── Controller.java.j2
│           ├── Hooks.java.j2        ← lifecycle hook interface
│           └── DefaultHooks.java.j2 ← @ConditionalOnMissingBean default impl
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
sqlite3   ← stdlib, used for the hooks registry
```

No Java required to run the generator — only to build the output projects.

---

## JavaDoc

Every generated class and method ships with full JavaDoc out of the box — entities, repositories, services, controllers, and both hook files. No extra steps needed.
