<?php

namespace Tests\Feature;

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
}
