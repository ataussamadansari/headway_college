---
last_mapped_commit: e27cd44232a119c5e4094f01049ef8310e2ba287
last_mapped_at: 2026-10-29
---
# Codebase Concerns

**Analysis Date:** 2026-10-28

## Tech Debt

**Dual Frontend Framework Configuration:**
- Issue: `package.json` and `vite.config.js` configure Tailwind CSS v4 (`@tailwindcss/vite`), while the active views and `resources/views/layouts/app.blade.php` rely on Bootstrap 5.3 CDN and custom inline CSS.
- Files: `package.json`, `vite.config.js`, `resources/views/layouts/app.blade.php`, `resources/css/app.css`
- Impact: Dual styling systems increase cognitive load, create risk of style collisions, and introduce confusion for developers writing new UI components.
- Fix approach: Standardize on a single design system — either fully adopt Bootstrap (via npm or CDN) or migrate Blade views to Tailwind CSS v4.

**Missing Database Transaction Boundary on Registration:**
- Issue: In `StudentController::store()` and `StudentController::update()`, student creation/updates and `syncEducationalQualifications()` occur in separate statements without a database transaction.
- Files: `app/Http/Controllers/StudentController.php:77-80`, `app/Http/Controllers/StudentController.php:127-130`
- Impact: If qualification saving fails due to an invalid mark format or database constraint, an orphaned student record exists without qualification records.
- Fix approach: Wrap student creation and qualification synchronization inside `DB::transaction(function () use (...) { ... });`.

**Orphaned File Accumulation on Edit:**
- Issue: When a student's photo or signature is replaced in `StudentController::update()`, new files are stored, but existing files on disk are not deleted.
- Files: `app/Http/Controllers/StudentController.php:111-125`
- Impact: Disk storage gradually accumulates unreferenced image files in `storage/app/public/students/`.
- Fix approach: Call `Storage::disk('public')->delete($student->photo_path)` when updating with a newly uploaded file.

## Known Bugs

**No known active production bugs identified.** System operates cleanly on standard registration and CRUD operations.

## Security Considerations

**Public File Storage Exposure:**
- Risk: Student photos and signatures are stored in `storage/app/public` with public HTTP URLs accessible without authentication checks if filenames are known.
- Files: `app/Http/Controllers/StudentController.php:68-74`, `app/Models/Student.php:68-79`
- Current mitigation: Files are assigned hashed random names (`store('...', 'public')`).
- Recommendations: If signatures are considered sensitive student PII, serve them through an authenticated route with access authorization checks (`Route::get('students/{student}/signature', ...)`).

## Performance Bottlenecks

**Unindexed Search Queries with Leading Wildcards:**
- Problem: `StudentController::index` performs `LIKE "%{$search}%"` across `name`, `college_register_no`, `control_no`, and `mobile`.
- Files: `app/Http/Controllers/StudentController.php:26-30`
- Cause: Leading wildcards prevent B-tree index usage, causing full table scans.
- Improvement path: As student records grow, consider full-text indexes or prefix matching where applicable.

## Fragile Areas

**Storage Symlink Dependency:**
- Files: `config/filesystems.php`, `public/storage`
- Why fragile: Displaying uploaded student photos and signatures relies on `php artisan storage:link`. In Windows or restricted server hosting environments, missing or broken symlinks lead to broken images across the UI.
- Safe modification: Document symlink verification in deployment scripts and check `Storage::disk('public')` health in administration checks.

## Scaling Limits

**Export Memory Limits on Large Datasets:**
- Current capacity: Memory-bound via Eloquent collection retrieval in `app/Exports/StudentsExport.php`.
- Limit: Datasets exceeding several thousand students may trigger PHP memory exhaustion (`memory_limit`).
- Scaling path: Refactor export queries to use cursor or chunked streaming via Maatwebsite Excel's `FromQuery` interface.

## Test Coverage Gaps

**Absence of Feature and Unit Tests:**
- What's not tested:
  - Student registration and qualification sync validation (`StudentController::store`)
  - File upload integrity (photo/signature max size, mime-types)
  - Course capacity enforcement and session active filters
  - Excel export and print report outputs
- Files: `app/Http/Controllers/StudentController.php`, `app/Http/Controllers/CourseController.php`, `app/Http/Controllers/SessionController.php`
- Risk: Refactoring models or controllers can introduce silent regressions unnoticed.
- Priority: High

---

*Concerns audit: 2026-10-28*
