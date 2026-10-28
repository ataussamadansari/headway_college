---
last_mapped_commit: e27cd44232a119c5e4094f01049ef8310e2ba287
last_mapped_at: 2026-10-29
---
# Coding Conventions

**Analysis Date:** 2026-10-28

## Naming Patterns

**Files:**
- Controllers: Singular or Plural resource name + `Controller.php` (`StudentController.php`, `DashboardController.php`)
- Models: Singular PascalCase (`Student.php`, `Course.php`, `EducationalQualification.php`)
- Form Requests: Verb + Resource + `Request.php` (`StoreStudentRequest.php`, `StoreCourseRequest.php`)
- Blade Templates: Lowercase snake_case or standard action names (`index.blade.php`, `create.blade.php`, `show.blade.php`, `app.blade.php`)

**Functions / Methods:**
- camelCase for controller methods and model helpers (`index`, `store`, `syncEducationalQualifications`, `getPhotoUrlAttribute`)
- camelCase for model relationships (`course()`, `session()`, `educationalQualifications()`)

**Variables & Properties:**
- camelCase for PHP variables and method parameters (`$request`, `$student`, `$totalStudents`, `$recentStudents`)
- snake_case for database columns and model attributes (`college_register_no`, `control_no`, `is_active`, `photo_path`)

**Types:**
- Explicit return types in newer controllers (e.g., `: View`, `: RedirectResponse` in `app/Http/Controllers/Auth/LoginController.php`)
- Strict type hinting where applicable (e.g., `StoreStudentRequest $request`, `Student $student`)

## Code Style

**Formatting:**
- PSR-12 standard enforced via Laravel Pint (`laravel/pint` in `composer.json`)
- 4-space indentation for PHP files
- Opening curly braces on next line for classes and methods, on same line for control structures

**Linting:**
- Pint executable: `vendor/bin/pint`

## Import Organization

**Order:**
1. Form Request imports (`use App\Http\Requests\StoreStudentRequest;`)
2. Model imports (`use App\Models\Student;`, `use App\Models\Course;`)
3. Framework / Support classes (`use Illuminate\Http\Request;`, `use Illuminate\Support\Facades\Storage;`)
4. Third-party packages (`use Maatwebsite\Excel\Facades\Excel;`)

**Path Aliases:**
- PSR-4 namespaces: `App\` mapped to `app/`, `Database\Factories\` mapped to `database/factories/`, `Database\Seeders\` mapped to `database/seeders/`, `Tests\` mapped to `tests/`.

## Error Handling

**Patterns:**
- HTTP Request Validation errors handled automatically by Laravel FormRequests:
  ```php
  // In StoreStudentRequest.php
  public function rules(): array
  {
      return [
          'college_register_no' => 'required|string|unique:students,college_register_no',
          // ...
      ];
  }
  ```
- Redirects with status flash messages in session:
  ```php
  return redirect()->route('students.index')->with('success', 'Student registered successfully!');
  return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
  ```
- Flash messages rendered via Bootstrap alerts in `resources/views/layouts/app.blade.php`.

## Logging

**Framework:** Monolog via Laravel `Log` facade (`Illuminate\Support\Facades\Log`).

**Patterns:**
- Errors logged automatically by framework handler to `storage/logs/laravel.log`.
- Artisan `pail` used for live terminal debugging.

## Comments

**When to Comment:**
- PHPDoc blocks preceding class methods describing purpose and parameter/return types:
  ```php
  /**
   * Display a listing of the students.
   */
  public function index(Request $request)
  ```
- Inline section dividers for complex multi-step processes (e.g., `// Search filter`, `// Course filter`, `// Handle photo upload`).

## Function Design

**Size:** Focused controller action methods typically under 30-50 lines.

**Parameters:** Prefer dependency injection (Route Model Binding and Request injection) rather than pulling directly from globals:
  ```php
  public function edit(Student $student)
  public function update(StoreStudentRequest $request, Student $student)
  ```

**Return Values:** Controller actions consistently return `View` (`view('students.index', ...)`) or `RedirectResponse` (`redirect()->route(...)`).

## Module Design

**Model Relationships:** Explicit Eloquent relationship methods returning `BelongsTo`, `HasMany`, etc.
**Synchronization Logic:** Extracted to private helper methods within controllers (e.g., `syncEducationalQualifications` in `StudentController.php`).

---

*Convention analysis: 2026-10-28*
