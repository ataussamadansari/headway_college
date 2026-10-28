<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Session;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_admin_login_when_visiting_dashboard(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_can_access_filament_dashboard(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@headwaycollege.com',
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Headway College ERP');
    }

    public function test_admin_can_view_student_resource_list(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('/admin/students');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_student_create_wizard(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('/admin/students/create');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_student_edit_page(): void
    {
        $admin = User::factory()->create();
        $course = Course::create([
            'code' => 'CS101',
            'name' => 'Computer Science',
            'total_seats' => 50,
            'is_active' => true,
        ]);
        $session = Session::create([
            'name' => '2026-2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
            'is_active' => true,
        ]);

        $student = Student::create([
            'college_register_no' => 'REG-001',
            'control_no' => 'CTRL-001',
            'registration_date' => '2026-10-29',
            'course_id' => $course->id,
            'session_id' => $session->id,
            'name' => 'John Doe',
            'father_name' => 'Richard Doe',
            'mother_name' => 'Jane Doe',
            'gender' => 'male',
            'dob' => '2004-05-15',
            'mobile' => '9876543210',
            'address' => '123 College Lane',
            'pincode' => '123456',
            'domicile_up' => true,
            'is_handicap' => false,
        ]);

        $response = $this->actingAs($admin)->get("/admin/students/{$student->id}/edit");

        $response->assertStatus(200);
    }

    public function test_admin_can_view_course_resource_list(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('/admin/courses');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_session_resource_list(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('/admin/sessions');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_student_print_slip(): void
    {
        $admin = User::factory()->create();
        $course = Course::create([
            'code' => 'CS102',
            'name' => 'Data Science',
            'total_seats' => 30,
            'is_active' => true,
        ]);
        $session = Session::create([
            'name' => '2026-2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
            'is_active' => true,
        ]);

        $student = Student::create([
            'college_register_no' => 'REG-002',
            'control_no' => 'CTRL-002',
            'registration_date' => '2026-10-29',
            'course_id' => $course->id,
            'session_id' => $session->id,
            'name' => 'Jane Smith',
            'father_name' => 'John Smith',
            'mother_name' => 'Mary Smith',
            'gender' => 'female',
            'dob' => '2005-03-21',
            'mobile' => '9876543211',
            'address' => '456 University Road',
            'pincode' => '654321',
            'domicile_up' => true,
            'is_handicap' => false,
        ]);

        $response = $this->actingAs($admin)->get("/students/{$student->id}/print");

        $response->assertStatus(200);
        $response->assertSee('Headway College');
        $response->assertSee('Jane Smith');
    }

    public function test_admin_can_access_student_roster_print(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('/students/report/print');

        $response->assertStatus(200);
        $response->assertSee('Headway College');
    }

    public function test_admin_can_view_session_infolist(): void
    {
        $admin = User::factory()->create();
        $session = Session::create([
            'name' => '2026-27',
            'start_date' => '2026-07-09',
            'end_date' => '2027-06-30',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get("/admin/sessions/{$session->id}");

        $response->assertStatus(200);
        $response->assertSee('Back to Sessions');
        $response->assertSee('Academic Session Overview');
    }

    public function test_admin_can_view_course_infolist(): void
    {
        $admin = User::factory()->create();
        $course = Course::create([
            'code' => 'BCA101',
            'name' => 'Bachelor of Computer Applications',
            'total_seats' => 60,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get("/admin/courses/{$course->id}");

        $response->assertStatus(200);
        $response->assertSee('Back to Courses');
        $response->assertSee('Course Overview');
    }

    public function test_admin_can_view_student_infolist(): void
    {
        $admin = User::factory()->create();
        $course = Course::create([
            'code' => 'BBA101',
            'name' => 'Bachelor of Business Administration',
            'total_seats' => 60,
            'is_active' => true,
        ]);
        $session = Session::create([
            'name' => '2026-2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
            'is_active' => true,
        ]);
        $student = Student::create([
            'college_register_no' => 'REG-101',
            'control_no' => 'CTRL-101',
            'registration_date' => '2026-10-29',
            'course_id' => $course->id,
            'session_id' => $session->id,
            'name' => 'Alex Turner',
            'father_name' => 'David Turner',
            'mother_name' => 'Sarah Turner',
            'gender' => 'male',
            'dob' => '2004-09-12',
            'mobile' => '9988776655',
            'address' => '789 Park Street',
            'pincode' => '226001',
            'domicile_up' => true,
            'is_handicap' => false,
        ]);

        $response = $this->actingAs($admin)->get("/admin/students/{$student->id}");

        $response->assertStatus(200);
        $response->assertSee('Back to Students');
        $response->assertSee('Admission & Identification');
        $response->assertSee('Print Slip');
    }
}
