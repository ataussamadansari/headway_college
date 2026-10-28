<!-- refreshed: 2026-10-28 -->
# Architecture

**Analysis Date:** 2026-10-28

## System Overview

```text
┌─────────────────────────────────────────────────────────────┐
│                    Presentation Layer                       │
│     Blade Templates + Bootstrap 5.3 + FontAwesome           │
│     `resources/views/` (layouts, students, courses, auth)   │
└──────────────────────────────┬──────────────────────────────┘
                               │ HTTP Requests / Forms
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                   Routing & Middleware                      │
│     `routes/web.php` (guest & auth middleware groups)       │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                     Controller Layer                        │
│     `app/Http/Controllers/`                                 │
│     (StudentController, CourseController, SessionController)│
└──────────────┬───────────────────────────────┬──────────────┘
               │                               │
               ▼                               ▼
┌──────────────────────────────┐┌─────────────────────────────┐
│     Form Request Validation  ││        Export Services      │
│  `app/Http/Requests/`        ││  `app/Exports/StudentsExport`│
│  (StoreStudentRequest, etc.) ││  (Maatwebsite Excel export) │
└──────────────┬───────────────┘└──────────────┬──────────────┘
               │                               │
               ▼                               ▼
┌─────────────────────────────────────────────────────────────┐
│                     Data / Model Layer                      │
│     Eloquent Models: `app/Models/`                          │
│     (Student, Course, Session, EducationalQualification)    │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│               Database & Storage Drivers                    │
│     Database: SQLite / MySQL via PDO migrations             │
│     Filesystem: `storage/app/public` (photos, signatures)   │
└─────────────────────────────────────────────────────────────┘
```

## Component Responsibilities

| Component | Responsibility | File |
|-----------|----------------|------|
| `DashboardController` | Aggregates summary stats, course counts, session distributions, and recent registrations | `app/Http/Controllers/DashboardController.php` |
| `StudentController` | Handles student CRUD, search/filtering, file upload persistence, qualification syncing, export, and printable reports | `app/Http/Controllers/StudentController.php` |
| `CourseController` | Handles course CRUD, active flag toggling, and seat capacity checks | `app/Http/Controllers/CourseController.php` |
| `SessionController` | Manages academic sessions, active/inactive statuses, and validity periods | `app/Http/Controllers/SessionController.php` |
| `LoginController` | Manages administrative authentication, session initialization, and session invalidation | `app/Http/Controllers/Auth/LoginController.php` |
| `Student` Model | Encapsulates student entity, attribute casting, file URL accessors, and relationships | `app/Models/Student.php` |
| `Course` Model | Encapsulates academic courses and student enrollment relationship | `app/Models/Course.php` |
| `Session` Model | Encapsulates academic sessions mapped to the `academic_sessions` table | `app/Models/Session.php` |
| `EducationalQualification` Model | Represents academic history entries linked to a student | `app/Models/EducationalQualification.php` |
| `StoreStudentRequest` | Enforces validation rules for student registrations, photos, and qualifications | `app/Http/Requests/StoreStudentRequest.php` |
| `StudentsExport` | Formats and exports student datasets into Excel spreadsheets | `app/Exports/StudentsExport.php` |

## Pattern Overview

**Overall:** Classic Laravel Model-View-Controller (MVC) with Form Request validation and Eloquent ORM.

**Key Characteristics:**
- **Explicit Form Requests**: Validation rules are isolated in dedicated `app/Http/Requests/*` classes rather than inline controller methods.
- **Relational Data Integrity**: Foreign keys link `students` to `courses` and `academic_sessions`, with cascading constraints on child `educational_qualifications`.
- **Server-Side Rendered Blade UI**: UI views are standard Blade templates utilizing layout inheritance (`resources/views/layouts/app.blade.php`).

## Layers

**Presentation Layer:**
- Purpose: Render responsive admin views, forms, search bars, and analytics widgets.
- Location: `resources/views/`
- Contains: Blade templates (`.blade.php`) structured by domain (`students/`, `courses/`, `sessions/`, `auth/`).
- Used by: Web browsers.

**Controller & Request Layer:**
- Purpose: Receive incoming HTTP requests, enforce authorization/validation, coordinate model queries, and return view responses or downloads.
- Location: `app/Http/Controllers/` and `app/Http/Requests/`
- Contains: Invokable and resource controllers, custom form request validators.
- Depends on: Models, storage facade, Excel facade.

**Domain / Persistence Layer:**
- Purpose: Define data relationships, cast database attributes, and manage relational queries.
- Location: `app/Models/`
- Contains: Eloquent model classes (`Student`, `Course`, `Session`, `EducationalQualification`, `User`).
- Depends on: Laravel Database / Eloquent ORM.

## Data Flow

### Primary Request Path (Student Registration)

1. Client submits registration form via `POST /students` (`routes/web.php:37`)
2. `StoreStudentRequest` validates fields, uniqueness (`college_register_no`, `control_no`), and file uploads (`app/Http/Requests/StoreStudentRequest.php`)
3. `StudentController::store` processes uploaded photo and signature files to `public` disk (`app/Http/Controllers/StudentController.php:67-74`)
4. Student record is created in `students` table via `Student::create($data)` (`app/Http/Controllers/StudentController.php:77`)
5. Associated qualifications are synchronized to `educational_qualifications` via `syncEducationalQualifications` (`app/Http/Controllers/StudentController.php:79`)
6. User is redirected to `students.index` with a flash success message (`app/Http/Controllers/StudentController.php:81`)

### Export / Reporting Flow

1. User requests `GET /students/export` with query filters (`routes/web.php:30`)
2. `StudentController::export` queries students based on search, course, and session filters (`app/Http/Controllers/StudentController.php:218-242`)
3. `Excel::download(new StudentsExport($query), 'students.xlsx')` triggers file download (`app/Http/Controllers/StudentController.php:244`)

**State Management:**
- Stateless HTTP backed by standard Laravel session cookies (`laravel_session`) stored via database or file sessions (`config/session.php`).

## Key Abstractions

**Form Request Abstraction:**
- Purpose: Decouples input validation logic from controller handlers.
- Examples: `app/Http/Requests/StoreStudentRequest.php`, `app/Http/Requests/StoreCourseRequest.php`.

**Asset URL Accessors:**
- Purpose: Eloquent dynamic accessors `getPhotoUrlAttribute()` and `getSignatureUrlAttribute()` encapsulate `asset('storage/...')` path generation.
- Examples: `app/Models/Student.php:68-79`.

## Entry Points

**Web Entry Point:**
- Location: `public/index.php`
- Triggers: All incoming HTTP web traffic via web server (or `php artisan serve`).
- Responsibilities: Bootstraps the Laravel application framework, handles kernel request pipeline, executes middleware, and sends HTTP response.

**CLI Entry Point:**
- Location: `artisan`
- Triggers: Console execution (`php artisan <command>`).
- Responsibilities: Executes migrations, seeders, route lists, queue listeners, and development servers.

## Error Handling

**Strategy:** Centralized framework exception handling in Laravel 12 bootstrap pipeline.

**Patterns:**
- Form validation failures trigger automatic HTTP 302 redirects back to previous input with session error flash messages (`$errors->first()`).
- Database model lookups use implicit route model binding (e.g., `Student $student`), failing automatically with HTTP 404 if not found.

## Cross-Cutting Concerns

**Logging:** Standard PSR-3 logging via `Log` facade and `config/logging.php`.
**Validation:** Declarative rules array in FormRequests (`StoreStudentRequest`, `StoreCourseRequest`, `StoreSessionRequest`).
**Authentication:** Cookie-based session authentication guarding all admin routes via `Route::middleware('auth')`.

---

*Architecture analysis: 2026-10-28*
