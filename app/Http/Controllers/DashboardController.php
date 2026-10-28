<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Session;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with statistics.
     */
    public function index()
    {
        $totalStudents = Student::count();
        $totalCourses = Course::count();
        $totalSessions = Session::count();
        $activeSessions = Session::where('is_active', true)->count();
        $activeCourses = Course::where('is_active', true)->count();

        // Students by course
        $studentsByCourse = Course::withCount('students')
            ->where('is_active', true)
            ->get();

        // Students by session
        $studentsBySession = Session::withCount('students')
            ->where('is_active', true)
            ->get();

        // Recent students
        $recentStudents = Student::with(['course', 'session'])
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalCourses',
            'totalSessions',
            'activeSessions',
            'activeCourses',
            'studentsByCourse',
            'studentsBySession',
            'recentStudents'
        ));
    }
}
