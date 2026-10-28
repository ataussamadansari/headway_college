---
last_mapped_commit: e27cd44232a119c5e4094f01049ef8310e2ba287
last_mapped_at: 2026-10-29
---
# External Integrations

**Analysis Date:** 2026-10-28

## APIs & External Services

**CDN Asset Delivery:**
- jsDelivr - Bootstrap 5.3.0 CSS and JS bundle (`resources/views/layouts/app.blade.php`)
- cdnjs (Cloudflare) - Font Awesome 6.4.0 stylesheet (`resources/views/layouts/app.blade.php`)

## Data Storage

**Databases:**
- SQLite / MySQL - Relational database configured in `config/database.php`
  - Connection: `DB_CONNECTION` env var (defaulting to SQLite or MySQL)
  - Client / ORM: Laravel Eloquent ORM (`Illuminate\Database\Eloquent\Model`)
  - Migrations: `database/migrations/` tracking `users`, `courses`, `academic_sessions`, `students`, and `educational_qualifications`

**File Storage:**
- Local Filesystem via Laravel Storage abstraction (`config/filesystems.php`)
  - Target Disk: `public` disk (`storage/app/public`)
  - Directories:
    - `students/photos` - Student profile photos (`photo_path` in `app/Models/Student.php`)
    - `students/signatures` - Student signatures (`signature_path` in `app/Models/Student.php`)
  - Public Symlink: `public/storage` linked to `storage/app/public` (`php artisan storage:link`)

**Caching & Queues:**
- Cache: Configured via `config/cache.php`, supporting database/file cache (`0001_01_01_000001_create_cache_table.php`)
- Queues: Configured via `config/queue.php`, supporting database queue driver (`0001_01_01_000002_create_jobs_table.php`)

## Authentication & Identity

**Auth Provider:**
- Custom / Laravel built-in Session Authentication
  - Implementation: `App\Http\Controllers\Auth\LoginController.php` using `Illuminate\Support\Facades\Auth`
  - User model: `App\Models\User.php`
  - Guard: Default `web` session guard with credential validation against hashed passwords (`Hash::make`)
  - Protection: `auth` middleware grouping protected admin routes (`routes/web.php`)

## Monitoring & Observability

**Error Tracking:**
- Laravel default error handling with `nunomaduro/collision` for CLI errors

**Logs:**
- Laravel standard logging configured in `config/logging.php` (writing to `storage/logs/laravel.log`)
- Real-time CLI log tailing supported via `laravel/pail` (`php artisan pail`)

## CI/CD & Deployment

**Hosting:**
- Standard PHP-compatible hosting environment (VPS, Shared Hosting, or Laravel Sail Docker container)

**CI Pipeline:**
- None configured in repository (no `.github/workflows` detected)

## Environment Configuration

**Required env vars:**
- `APP_KEY` - Application encryption key
- `APP_ENV` - Environment name (local, production)
- `APP_DEBUG` - Debug mode toggle
- `DB_CONNECTION` - Database driver (`sqlite`, `mysql`)
- `DB_DATABASE` - Database name or sqlite file path

**Secrets location:**
- Stored exclusively in local `.env` file (not committed to version control; tracked via `.env.example`)

## Webhooks & Callbacks

**Incoming:**
- None detected

**Outgoing:**
- None detected

---

*Integration audit: 2026-10-28*
