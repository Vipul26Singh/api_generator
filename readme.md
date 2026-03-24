# API Generator

A full-featured REST API and CRUD generation platform built on **CodeIgniter 3**, designed for rapid development of inventory management systems. It includes an auto-generated admin dashboard, form builder, equipment tracking, and event management — all wired up with JWT-based REST APIs.

---

## Features

- **CRUD Generator** — Auto-generate Create, Read, Update, Delete operations from database tables
- **REST API Generation** — Instantly create JSON APIs from your schema
- **JWT Authentication** — Secure token-based authentication for all API endpoints
- **Role-Based Access Control (RBAC)** — Granular permission system with groups and users
- **Admin Dashboard** — Full AdminLTE Material theme admin panel
- **Form Builder** — Build custom forms with conditional logic, file uploads, and PDF export
- **Equipment Management** — Track inventory, categories, availability, check-in/check-out
- **Event Management** — Manage events (ongoing, past, future) and equipment allocation
- **Page/CMS Builder** — Create and manage static pages and content
- **Extension System** — Plugin architecture for custom functionality
- **Multi-language Support** — 50+ language packs included

---

## Tech Stack

| Component      | Technology                        |
|----------------|-----------------------------------|
| Framework      | CodeIgniter 3                     |
| Language       | PHP 5.4+                          |
| Database       | MySQL 5.7+                        |
| Auth           | AAAuth + Firebase JWT             |
| API Layer      | REST_Controller v3.0.0            |
| PDF Generation | DomPDF                            |
| Frontend       | AdminLTE Material, Bootstrap, jQuery |

---

## Requirements

- PHP 5.4 or higher
- MySQL 5.7 or higher
- Apache with `mod_rewrite` enabled
- Composer

---

## Installation

### 1. Clone the repository

```bash
git clone <repo-url>
cd api_generator
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure the database

Edit `/application/config/database.php`:

```php
'hostname' => 'localhost',
'username' => 'your_db_user',
'password' => 'your_db_password',
'database' => 'crisp_inventory',
'dbdriver' => 'mysqli',
```

### 4. Import the database schema

```bash
mysql -u your_db_user -p crisp_inventory < db_blank.sql
```

### 5. Configure your base URL

Edit `/application/config/config.php` and set:

```php
$config['base_url'] = 'http://yourdomain.com/';
```

### 6. Set file permissions

```bash
chmod -R 755 uploads/
chmod -R 755 application/cache/
chmod -R 755 application/logs/
```

### 7. Enable Apache mod_rewrite

Ensure `.htaccess` is respected and `AllowOverride All` is set in your Apache virtual host config.

### 8. Run the setup wizard

Visit `http://yourdomain.com/wizzard/language` to complete the initial setup and create an admin account.

---

## Accessing the Application

| URL | Description |
|-----|-------------|
| `http://yourdomain.com/` | Public frontend |
| `http://yourdomain.com/administrator` | Admin dashboard |
| `http://yourdomain.com/apidoc/` | API documentation |
| `http://yourdomain.com/api/` | REST API base |

---

## REST API

### Authentication

**Login and get a JWT token:**

```http
POST /api/user/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "your_password"
}
```

**Use the token in subsequent requests:**

```http
GET /api/events/all
X-Api-Key: your_api_key
X-Token: your_jwt_token
```

---

### API Endpoints

#### Events

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/events/all` | List all events |
| GET | `/api/events/detail` | Get event details |
| GET | `/api/events/future` | List future events |
| GET | `/api/events/past` | List past events |
| GET | `/api/events/ongoing` | List ongoing events |

#### Equipment

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/equipments/all` | List all equipment |
| GET | `/api/equipments/detail` | Get equipment details |
| GET | `/api/equipments/available` | List available equipment |
| GET | `/api/equipments/not_available` | List unavailable equipment |
| GET | `/api/equipment_category/all` | List equipment categories |
| POST | `/api/equipment_checkin/add` | Check in equipment |
| POST | `/api/event_equipment_checkout/add` | Check out equipment for event |
| GET | `/api/event_equipment_checklist/all` | Get event equipment checklist |

#### Users & Groups

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/user/login` | Login and get token |
| GET | `/api/user/all` | List all users (admin) |
| GET | `/api/group/all` | List groups/roles |
| POST | `/api/group/add` | Create a new group |

#### Static Pages

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/static_pages/all` | List all static pages |
| GET | `/api/static_pages/detail` | Get page content |

**API Response Format:**

```json
{
  "status": true,
  "message": "success",
  "data": [...],
  "total": 10
}
```

---

## Project Structure

```
api_generator/
├── application/
│   ├── config/             # App, database, REST, auth configuration
│   ├── controllers/
│   │   ├── api/            # REST API controllers
│   │   └── administrator/  # Admin panel controllers
│   ├── models/             # Data models
│   ├── views/
│   │   ├── backend/        # Admin panel views
│   │   └── frontend/       # Public views
│   ├── core/               # Extended base classes (controller, model, router)
│   ├── libraries/          # REST_Controller, JWT, CRUD builder, OAuth2
│   ├── helpers/            # Custom helper functions
│   ├── language/           # Internationalization files
│   └── migrations/         # Database migrations
├── system/                 # CodeIgniter system files
├── asset/                  # CSS, JS, fonts, and frontend assets
├── apidoc/                 # Generated API documentation (APIDoc)
├── cc-content/
│   └── extensions/         # Plugins (themes, editors, form builder)
├── uploads/                # User-uploaded files
├── form_builder/           # Standalone form builder app
├── vendor/                 # Composer dependencies
├── db_blank.sql            # Database schema
└── index.php               # Application entry point
```

---

## Database

The application uses a MySQL database named `crisp_inventory`. The schema is included in `db_blank.sql`.

**Key tables:**

| Table | Description |
|-------|-------------|
| `aauth_users` | User accounts |
| `aauth_groups` | Roles/groups |
| `aauth_perms` | Permission definitions |
| `equipments` | Equipment inventory |
| `equipment_category` | Equipment categories |
| `events` | Event records |
| `event_equipment_checkout` | Equipment checkouts per event |
| `equipment_checkin` | Equipment check-in history |
| `crud` / `crud_field` | CRUD generator definitions |
| `cc_options` | System settings |

---

## Configuration

### REST API (`application/config/rest.php`)

- Default output format: `JSON`
- Also supports: `xml`, `csv`, `html`, `jsonp`, `serialized`
- Status field key: `status`
- Message field key: `message`

### Pagination (`application/config/page_constants.php`)

```php
define('PAGE_LIMIT', 50);   // Records per page
```

### Timezone

Set via admin settings or `cc_options` table with the `timezone` key.

---

## Extending the API

### Adding a new endpoint

1. Create a controller in `application/controllers/api/`:

```php
class YourResource extends API {
    public function all_get() {
        $this->load->model('model_api_yourresource');
        $data = $this->model_api_yourresource->get($this->get());
        $this->response(['status' => true, 'data' => $data], 200);
    }
}
```

2. Create a model in `application/models/`:

```php
class Model_api_yourresource extends MY_Model {
    private $table_name = 'your_table';
    // Implement get() and count_all()
}
```

3. Register the required permissions in `aauth_perms`.

---

## Third-Party Libraries

| Library | Purpose | Source |
|---------|---------|--------|
| CodeIgniter Aauth | Authentication & authorization | [GitHub](https://github.com/emreakay/CodeIgniter-Aauth) |
| Template Library | View templating | [GitHub](https://github.com/philsturgeon/codeigniter-template) |
| Firebase JWT | JWT token encoding/decoding | — |
| DomPDF | PDF generation | — |
| Fine Uploader | File uploads | http://fineuploader.com/ |
| Toastr | Toast notifications | [GitHub](https://github.com/CodeSeven/toastr) |
| jQuery Hotkeys | Keyboard shortcuts | [GitHub](https://github.com/jeresig/jquery.hotkeys) |
| jQuery JSONView | JSON display | [GitHub](https://github.com/ridwanskaterock/jquery-jsonview) |
| jQuery AddressPicker | Map/address picker | [GitHub](https://github.com/bygiro/jQuery-AddressPicker-ByGiro/) |
| Spectrum | Color picker | [GitHub](https://github.com/bgrins/spectrum) |
| Medium Editor | Rich text editor | [GitHub](https://github.com/yabwe/medium-editor) |
| AdminLTE Material | Admin UI theme | — |

---

## Security Notes

- Change the default database credentials before deploying to production
- Set `ENVIRONMENT` to `'production'` in `index.php` (already set)
- Use HTTPS in production — update `$config['base_url']` accordingly
- Rotate JWT secrets and API keys regularly
- Set proper file permissions on `uploads/` and `application/cache/`

---

## License

This project is open source. See individual library licenses for third-party dependencies.
