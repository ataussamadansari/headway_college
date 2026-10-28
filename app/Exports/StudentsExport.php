<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Student::query()->with(['course', 'session']);

        // Apply filters
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('college_register_no', 'like', "%{$search}%");
        }

        if ($this->request->filled('course_id')) {
            $query->where('course_id', $this->request->course_id);
        }

        if ($this->request->filled('session_id')) {
            $query->where('session_id', $this->request->session_id);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Register No',
            'Control No',
            'Name',
            'Father Name',
            'Mother Name',
            'Gender',
            'DOB',
            'Mobile',
            'Course',
            'Session',
            'Religion',
            'Category',
            'Domicile UP',
            'Handicap',
            'Address',
            'Pincode',
            'Registration Date',
        ];
    }

    public function map($student): array
    {
        return [
            $student->college_register_no,
            $student->control_no,
            $student->name,
            $student->father_name,
            $student->mother_name,
            ucfirst($student->gender),
            $student->dob->format('d-m-Y'),
            $student->mobile,
            $student->course->name ?? 'N/A',
            $student->session->name ?? 'N/A',
            $student->religion ?? 'N/A',
            $student->category ?? 'N/A',
            $student->domicile_up ? 'Yes' : 'No',
            $student->is_handicap ? 'Yes' : 'No',
            $student->address,
            $student->pincode,
            $student->registration_date->format('d-m-Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '0D47A1']],
            ],
        ];
    }
}
