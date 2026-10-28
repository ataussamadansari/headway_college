<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Session;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed or update secure Admin User from environment variables
        $adminName = env('ADMIN_NAME', 'Administrator');
        $adminEmail = env('ADMIN_EMAIL', 'admin@headwaycollege.com');
        $adminPassword = env('ADMIN_PASSWORD', 'password');

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => $adminName,
                'password' => Hash::make($adminPassword),
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed Default Courses if none exist
        $courses = [
            [
                'code' => 'BTECH-CS',
                'name' => 'B.Tech - Computer Science & Engineering',
                'description' => '4-year undergraduate degree in computer science and engineering.',
                'duration' => '4 Years',
                'total_seats' => 60,
                'is_active' => true,
            ],
            [
                'code' => 'BCA',
                'name' => 'Bachelor of Computer Applications (BCA)',
                'description' => '3-year degree focused on computer application development and IT.',
                'duration' => '3 Years',
                'total_seats' => 80,
                'is_active' => true,
            ],
            [
                'code' => 'BBA',
                'name' => 'Bachelor of Business Administration (BBA)',
                'description' => '3-year program covering management principles and business administration.',
                'duration' => '3 Years',
                'total_seats' => 60,
                'is_active' => true,
            ],
            [
                'code' => 'MBA',
                'name' => 'Master of Business Administration (MBA)',
                'description' => '2-year postgraduate program specializing in leadership and enterprise management.',
                'duration' => '2 Years',
                'total_seats' => 40,
                'is_active' => true,
            ],
        ];

        foreach ($courses as $courseData) {
            Course::updateOrCreate(['code' => $courseData['code']], $courseData);
        }

        // 3. Seed Default Academic Sessions if none exist
        $sessions = [
            [
                'name' => '2024-2025',
                'start_date' => '2024-07-01',
                'end_date' => '2025-06-30',
                'remarks' => 'Academic session 2024-2025',
                'is_active' => true,
            ],
            [
                'name' => '2025-2026',
                'start_date' => '2025-07-01',
                'end_date' => '2026-06-30',
                'remarks' => 'Current active academic session 2025-2026',
                'is_active' => true,
            ],
            [
                'name' => '2026-2027',
                'start_date' => '2026-07-01',
                'end_date' => '2027-06-30',
                'remarks' => 'Upcoming academic session 2026-2027',
                'is_active' => true,
            ],
        ];

        foreach ($sessions as $sessionData) {
            Session::updateOrCreate(['name' => $sessionData['name']], $sessionData);
        }
    }
}

