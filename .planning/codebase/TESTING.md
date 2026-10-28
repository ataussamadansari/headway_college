---
last_mapped_commit: e27cd44232a119c5e4094f01049ef8310e2ba287
last_mapped_at: 2026-10-29
---
# Testing Patterns

**Analysis Date:** 2026-10-28

## Test Framework

**Runner:**
- PHPUnit `^11.5.50` (`phpunit/phpunit` in `composer.json`)
- Config: `phpunit.xml`

**Assertion Library:**
- PHPUnit built-in assertions (`$this->assertTrue(...)`, `$this->assertDatabaseHas(...)`)
- Laravel HTTP Test assertions (`$response->assertStatus(200)`, `$response->assertRedirect(...)`)

**Run Commands:**

```bash
php artisan test       # Run all tests via Laravel Artisan runner
./vendor/bin/phpunit   # Run PHPUnit directly
composer test          # Clear config cache and run tests
```

## Test File Organization

**Location:**
- Co-located inside `tests/` directory:
  - `tests/Feature/` - HTTP requests, controller logic, full stack integration tests
  - `tests/Unit/` - Isolated unit tests without full application boot
  - `tests/TestCase.php` - Base test case extending `Illuminate\Foundation\Testing\TestCase`

**Naming:**
- Suffix `Test.php` (e.g., `ExampleTest.php`, `StudentRegistrationTest.php`)

**Structure:**

```
tests/
├── Feature/
│   └── ExampleTest.php
├── Unit/
│   └── ExampleTest.php
└── TestCase.php
```

## Test Structure

**Suite Organization:**

```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dashboard(): void
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Headway College');
    }
}
```

**Patterns:**
- `use RefreshDatabase;` trait resets SQLite in-memory database between tests.
- `$this->actingAs($user)` sets authenticated session context.
- `$response->assertRedirect(...)` tests post-submission redirects.
- `$this->assertDatabaseHas('students', [...])` verifies database records.

## Mocking

**Framework:**
- Mockery `^1.6` (`mockery/mockery` in `composer.json`)
- Laravel built-in facade fakes (`Storage::fake('public')`, `Excel::fake()`)

**Patterns:**

```php
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

public function test_student_photo_upload(): void
{
    Storage::fake('public');

    $file = UploadedFile::fake()->image('avatar.jpg');
    // submit file with student creation request...

    Storage::disk('public')->assertExists('students/photos/' . $file->hashName());
}
```

**What to Mock:**
- File uploads (`Storage::fake('public')`)
- Excel exports (`Excel::fake()`)
- External mail/notification services

**What NOT to Mock:**
- Database queries (use SQLite in-memory with `RefreshDatabase` for true persistence testing)
- Form requests (allow validator to execute full validation rules)

## Fixtures and Factories

**Test Data:**
- Factory pattern using Eloquent factories:
  - `database/factories/UserFactory.php`
- Location: `database/factories/`

## Coverage

**Requirements:**
- None formally enforced yet. Current test suite contains minimal default starter tests.

**View Coverage:**

```bash
php artisan test --coverage
```

*(Requires Xdebug or PCOV extension)*

## Test Types

**Unit Tests:**
- Scope: Isolated calculation or string formatting helpers in models.
- Location: `tests/Unit/`

**Feature Tests:**
- Scope: HTTP endpoints, authentication gates, form validation, file uploads, database writes, and Excel generation.
- Location: `tests/Feature/`

**E2E Tests:**
- Not currently configured in codebase.

---

*Testing analysis: 2026-10-28*
