---
last_mapped_commit: e27cd44232a119c5e4094f01049ef8310e2ba287
last_mapped_at: 2026-10-29
---
# Codebase Structure

**Analysis Date:** 2026-10-28

## Directory Layout

```
headwaycollege/
├── app/                           # Application core code
│   ├── Exports/                   # Maatwebsite Excel export classes (StudentsExport.php)
│   ├── Http/
│   │   ├── Controllers/           # Application controllers (Student, Course, Session, Dashboard)
│   │   │   └── Auth/              # Authentication controllers (LoginController.php)
│   │   └── Requests/              # Form request validation classes (StoreStudentRequest, etc.)
│   └── Models/                    # Eloquent database models (Student, Course, Session, User)
├── bootstrap/                     # Framework bootstrap and application configuration
│   ├── app.php                    # Application builder and middleware routing configuration
│   └── providers.php              # Service provider registrations
├── config/                        # Configuration files (app, auth, database, filesystems, session)
├── database/                      # Database migrations, seeders, and factories
│   ├── factories/                 # Eloquent factories for test data generation
│   ├── migrations/                # Database schema migration files
│   └── seeders/                   # Database seeders (DatabaseSeeder.php)
├── public/                        # Web server root
│   ├── index.php                  # Web request entry point
│   └── storage/                   # Symlink to storage/app/public for public assets
├── resources/                     # Presentation resources
│   ├── css/                       # Frontend stylesheets (app.css)
│   ├── js/                        # Frontend JavaScript (app.js, bootstrap.js)
│   └── views/                     # Blade view templates
│       ├── auth/                  # Authentication views (login.blade.php)
│       ├── courses/               # Course management views (index, create, edit, show)
│       ├── layouts/               # Master view layouts (app.blade.php)
│       ├── sessions/              # Session management views (index, create, edit, show)
│       ├── students/              # Student views (index, create, edit, show, print)
│       ├── dashboard.blade.php    # Dashboard analytics and overview
│       └── welcome.blade.php      # Default landing view
├── routes/                        # Application route definitions
│   ├── console.php                # Artisan console command routes
│   └── web.php                    # Web HTTP routes and middleware definitions
├── storage/                       # Storage for logs, framework cache, and uploaded files
│   └── app/public/                # Uploaded student photos and signatures
├── tests/                         # Automated tests
│   ├── Feature/                   # Integration/feature tests (ExampleTest.php)
│   ├── Unit/                      # Unit tests (ExampleTest.php)
│   └── TestCase.php               # Base test case class
├── artisan                        # Laravel Artisan command-line executable
├── composer.json                  # PHP dependency manifest
├── package.json                   # Node.js dependency manifest
├── phpunit.xml                    # PHPUnit testing configuration
└── vite.config.js                 # Vite asset compilation configuration
```

## Directory Purposes

**`app/Http/Controllers/`:**
- Purpose: Orchestrates incoming requests, retrieves data through models, and renders Blade views.
- Key files: `app/Http/Controllers/StudentController.php`, `app/Http/Controllers/DashboardController.php`.

**`app/Http/Requests/`:**
- Purpose: Isolates form validation rules and authorization checks for user inputs.
- Key files: `app/Http/Requests/StoreStudentRequest.php`, `app/Http/Requests/StoreCourseRequest.php`.

**`app/Models/`:**
- Purpose: Defines Eloquent entities, relationships, casts, and helper accessors.
- Key files: `app/Models/Student.php`, `app/Models/Course.php`, `app/Models/Session.php`, `app/Models/EducationalQualification.php`.

**`resources/views/`:**
- Purpose: Holds all Blade UI templates, component partials, and layouts.
- Key files: `resources/views/layouts/app.blade.php`, `resources/views/dashboard.blade.php`, `resources/views/students/index.blade.php`.

**`database/migrations/`:**
- Purpose: Defines version-controlled database schema migrations.
- Key files: `database/migrations/2025_03_24_100003_create_students_table.php`.

## Key File Locations

**Entry Points:**
- `public/index.php`: Primary web entry point.
- `artisan`: Primary console entry point.

**Configuration:**
- `config/database.php`: Database connection and driver definitions.
- `config/filesystems.php`: File storage disk definitions.
- `config/auth.php`: Authentication guards and providers.

**Core Logic:**
- `app/Http/Controllers/StudentController.php`: Core student registration logic, document handling, qualification synchronization, and reporting.

**Testing:**
- `tests/TestCase.php`: Base test case.
- `phpunit.xml`: Test environment configuration (SQLite in-memory settings).

## Naming Conventions

**Files:**
- Controllers: `*Controller.php` (e.g., `StudentController.php`)
- Models: Singular PascalCase `*.php` (e.g., `Student.php`, `Course.php`)
- Form Requests: `Store*Request.php` / `Update*Request.php` (e.g., `StoreStudentRequest.php`)
- Views: kebab-case/lowercase `.blade.php` (e.g., `index.blade.php`, `app.blade.php`)
- Migrations: `YYYY_MM_DD_HHMMSS_*.php`

**Directories:**
- Plural lowercase for views (`resources/views/students/`, `resources/views/courses/`)
- PascalCase for PHP namespaces (`app/Http/Controllers/`, `app/Models/`)

## Where to Add New Code

**New Feature (e.g., Fee Management or Attendance):**
- Model: `app/Models/Fee.php`
- Migration: `database/migrations/YYYY_MM_DD_HHMMSS_create_fees_table.php`
- Controller: `app/Http/Controllers/FeeController.php`
- Form Requests: `app/Http/Requests/StoreFeeRequest.php`
- Views: `resources/views/fees/index.blade.php`, `resources/views/fees/create.blade.php`
- Routes: `routes/web.php` under the `auth` middleware group
- Tests: `tests/Feature/FeeManagementTest.php`

**New Export / Report:**
- Implementation: `app/Exports/*Export.php`
- Controller action in `StudentController.php` or dedicated `ReportController.php`

**Utilities & Shared Helpers:**
- Helpers / Services: `app/Services/` or custom Traits in `app/Traits/`

## Special Directories

**`storage/app/public/`:**
- Purpose: Stores student uploads (`students/photos/`, `students/signatures/`).
- Generated: Yes (at runtime upon upload).
- Committed: No (contents ignored via `.gitignore`).

**`vendor/` and `node_modules/`:**
- Purpose: Third-party composer and npm dependencies.
- Generated: Yes.
- Committed: No.

---

*Structure analysis: 2026-10-28*
