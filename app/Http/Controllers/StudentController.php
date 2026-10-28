<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use App\Models\Course;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index(Request $request)
    {
        $query = Student::with(['course', 'session']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('college_register_no', 'like', "%{$search}%")
                  ->orWhere('control_no', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
        }

        // Course filter
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Session filter
        if ($request->filled('session_id')) {
            $query->where('session_id', $request->session_id);
        }

        $students = $query->paginate(15);
        $courses = Course::where('is_active', true)->get();
        $sessions = Session::where('is_active', true)->get();

        return view('students.index', compact('students', 'courses', 'sessions'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $courses = Course::where('is_active', true)->get();
        $sessions = Session::where('is_active', true)->get();
        return view('students.create', compact('courses', 'sessions'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $data = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('students/photos', 'public');
        }

        // Handle signature upload
        if ($request->hasFile('signature')) {
            $data['signature_path'] = $request->file('signature')->store('students/signatures', 'public');
        }

        // Create student
        $student = Student::create($data);

        $this->syncEducationalQualifications($student, $request->input('educational_qualifications'));

        return redirect()->route('students.index')->with('success', 'Student registered successfully!');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load(['course', 'session', 'educationalQualifications']);
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $student->load(['course', 'session', 'educationalQualifications']);
        $courses = Course::where('is_active', true)->get();
        $sessions = Session::where('is_active', true)->get();
        return view('students.edit', compact('student', 'courses', 'sessions'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(StoreStudentRequest $request, Student $student)
    {
        $data = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('students/photos', 'public');
        }

        // Handle signature upload
        if ($request->hasFile('signature')) {
            // Delete old signature
            if ($student->signature_path) {
                Storage::disk('public')->delete($student->signature_path);
            }
            $data['signature_path'] = $request->file('signature')->store('students/signatures', 'public');
        }

        $student->update($data);

    $this->syncEducationalQualifications($student, $request->input('educational_qualifications'));

        return redirect()->route('students.show', $student)->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        // Delete associated files
        if ($student->photo_path) {
            Storage::disk('public')->delete($student->photo_path);
        }
        if ($student->signature_path) {
            Storage::disk('public')->delete($student->signature_path);
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }

    /**
     * Export students to Excel
     */
    public function export(Request $request)
    {
        $filename = 'students_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new StudentsExport($request), $filename);
    }

    /**
     * Print student report
     */
    public function print(Request $request)
    {
        $query = Student::with(['course', 'session']);

        // Apply filters same as index
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
     * Print individual student details
     */
    public function printStudent(Student $student)
    {
        $student->load(['course', 'session', 'educationalQualifications']);
        return view('students.print-single', compact('student'));
    }

    /**
     * Save or replace educational qualifications for a student from form JSON payload.
     */
    private function syncEducationalQualifications(Student $student, ?string $qualificationsJson): void
    {
        if ($qualificationsJson === null) {
            return;
        }

        $qualifications = json_decode($qualificationsJson, true);

        if (!is_array($qualifications)) {
            return;
        }

        $qualificationTypeMap = [
            '10th' => 'highschool',
            '12th' => 'intermediate',
            'Bachelor' => 'ug',
            'Master' => 'ug',
            'Diploma' => 'ug',
            'Certificate' => 'ug',
            'highschool' => 'highschool',
            'intermediate' => 'intermediate',
            'ug' => 'ug',
        ];

        $rowsToInsert = [];

        foreach ($qualifications as $qual) {
            $mappedType = $qualificationTypeMap[$qual['qualification_type'] ?? ''] ?? null;
            $boardUniversity = trim((string) ($qual['board_university'] ?? ''));
            $stream = trim((string) ($qual['stream'] ?? ''));
            $yearOfCompletion = (int) ($qual['year_of_completion'] ?? 0);
            $rollNumber = trim((string) ($qual['roll_number'] ?? ''));
            $maxMarksRaw = $qual['max_marks'] ?? null;
            $obtainedMarksRaw = $qual['obtained_marks'] ?? null;

            if (
                !$mappedType ||
                $boardUniversity === '' ||
                $stream === '' ||
                $yearOfCompletion <= 0 ||
                $rollNumber === '' ||
                $maxMarksRaw === null ||
                $obtainedMarksRaw === null ||
                $maxMarksRaw === '' ||
                $obtainedMarksRaw === ''
            ) {
                continue;
            }

            $maxMarks = (int) $maxMarksRaw;
            $obtainedMarks = (int) $obtainedMarksRaw;

            $rowsToInsert[] = [
                'qualification_type' => $mappedType,
                'board_university' => $boardUniversity,
                'stream' => $stream,
                'year_of_completion' => $yearOfCompletion,
                'roll_number' => $rollNumber,
                'max_marks' => $maxMarks,
                'obtained_marks' => $obtainedMarks,
                'percentage' => $maxMarks > 0 ? ($obtainedMarks / $maxMarks) * 100 : null,
            ];
        }

        $student->educationalQualifications()->delete();

        if (!empty($rowsToInsert)) {
            $student->educationalQualifications()->createMany($rowsToInsert);
        }
    }
}
