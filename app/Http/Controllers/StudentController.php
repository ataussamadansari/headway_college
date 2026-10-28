<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Export students to Excel.
     */
    public function export(Request $request)
    {
        $filename = 'students_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new StudentsExport($request), $filename);
    }

    /**
     * Print student roster / report.
     */
    public function print(Request $request)
    {
        $query = Student::with(['course', 'session']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('college_register_no', 'like', "%{$search}%");
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('session_id')) {
            $query->where('session_id', $request->session_id);
        }

        $students = $query->get();

        return view('students.print', compact('students'));
    }

    /**
     * Print individual student registration slip / details.
     */
    public function printStudent(Student $student)
    {
        $student->load(['course', 'session', 'educationalQualifications']);

        return view('students.print-single', compact('student'));
    }
}
