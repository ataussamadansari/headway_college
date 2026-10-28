---
last_mapped_commit: e27cd44232a119c5e4094f01049ef8310e2ba287
last_mapped_at: 2026-10-29
---
# Technology Stack

**Analysis Date:** 2026-10-28

## Languages

**Primary:**
- PHP ^8.2 - Backend application logic, controllers, models, and migrations (`app/`, `database/`, `routes/`)

**Secondary:**
- JavaScript (ES Modules) - Frontend tooling and optional client interactions (`resources/js/app.js`, `vite.config.js`)
- HTML / Blade - Server-rendered templates (`resources/views/`)
- CSS - Styling and layout (`resources/css/app.css`, embedded styles in `resources/views/layouts/app.blade.php`)

## Runtime

**Environment:**
- PHP 8.2+ CLI / Web Server (`php artisan serve`)
- Node.js (for asset compilation via Vite)

**Package Manager:**
- Composer 2.x
  - Lockfile: `composer.lock` present
- npm / npx
  - Lockfile: not committed (`package-lock.json` absent; `package.json` present)

## Frameworks

**Core:**
- Laravel `^12.0` (`laravel/framework` in `composer.json`) - Core MVC framework
- Laravel Tinker `^2.10.1` - Interactive REPL environment

**Frontend & UI:**
- Bootstrap 5.3.0 (via jsDelivr CDN in `resources/views/layouts/app.blade.php`) - Primary UI layout and component styling
- Font Awesome 6.4.0 (via cdnjs in `resources/views/layouts/app.blade.php`) - Iconography
- Tailwind CSS `^4.0.0` with `@tailwindcss/vite` `^4.0.0` (in `package.json`) - Configured for asset bundling via Vite

**Testing:**
- PHPUnit `^11.5.50` (`phpunit/phpunit` in `composer.json`, configured via `phpunit.xml`) - Unit and integration testing
- Mockery `^1.6` - Mock object generation
- Faker `^1.23` - Test data generation

**Build/Dev:**
- Vite `^7.0.7` (`vite.config.js`) - Frontend asset bundler
- Laravel Vite Plugin `^2.0.0` (`laravel-vite-plugin`) - Laravel Vite integration
- Concurrently `^9.0.1` - Multi-process development runner (`npm run dev` / `composer run dev`)
- Laravel Pint `^1.24` - PHP code style fixer
- Laravel Sail `^1.41` - Docker environment
- Laravel Pail `^1.2.2` - CLI log viewer

## Key Dependencies

**Critical:**
- `maatwebsite/excel` `^3.1` (`composer.json`) - Excel export for student records (`app/Exports/StudentsExport.php`)

**Infrastructure:**
- `nunomaduro/collision` `^8.6` - Error handler and CLI exception reporting

## Configuration

**Environment:**
- `.env.example` present - Template for environment configuration
- `.env` present - Local runtime configuration (database, app keys, mail, session)
- Key configurations: `APP_KEY`, `DB_CONNECTION`, `DB_DATABASE`, `SESSION_DRIVER`

**Build:**
- `vite.config.js` - Vite bundling configuration with `laravel-vite-plugin` and `@tailwindcss/vite`
- `composer.json` - Autoloading, scripts (`dev`, `test`, `setup`), and minimum stability settings

## Platform Requirements

**Development:**
- PHP 8.2+ with PDO, SQLite/MySQL, cURL, OpenSSL, Mbstring, and GD/Imagick extensions
- Node.js 18+ and npm
- SQLite or MySQL database

**Production:**
- Standard Linux / Windows web server (Nginx / Apache + PHP-FPM)
- MySQL / MariaDB or PostgreSQL database
- Persistent storage for file uploads (`public/storage` symlink to `storage/app/public`)

---

*Stack analysis: 2026-10-28*
