<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report - Headway College</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0D47A1;
            padding-bottom: 20px;
        }
        .brand-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        .brand-logo {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border: 1px solid #cfd8dc;
            border-radius: 8px;
            padding: 2px;
            background: #fff;
        }
        .header h1 {
            color: #0D47A1;
            margin-bottom: 5px;
        }
        .table thead {
            background-color: #E3F2FD;
            color: #0D47A1;
        }
        .print-btn {
            margin-bottom: 20px;
        }
        @media print {
            .print-btn {
                display: none;
            }
            body {
                padding: 0;
            }
        }
        @media (max-width: 600px) {
            .brand-header {
                flex-direction: column;
                gap: 6px;
            }
            .brand-logo {
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <div class="print-btn">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </button>
        <button class="btn btn-secondary" onclick="window.history.back()">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </div>

    <div class="header">
        <div class="brand-header">
            <img src="{{ asset('img/headway%20logo.jpeg') }}" alt="Headway College Logo" class="brand-logo">
            <div>
                <h1>Headway College</h1>
                <p>Student Report</p>
                <p>Generated on {{ date('d M Y H:i A') }}</p>
            </div>
        </div>
    </div>

    @if($students->isEmpty())
        <div class="alert alert-info">No students found</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Register No</th>
                        <th>Control No</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Course</th>
                        <th>Session</th>
                        <th>Mobile</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->college_register_no }}</td>
                            <td>{{ $student->control_no }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->father_name }}</td>
                            <td>{{ ucfirst($student->gender) }}</td>
                            <td>{{ $student->dob->format('d/m/Y') }}</td>
                            <td>{{ $student->course->name ?? 'N/A' }}</td>
                            <td>{{ $student->session->name ?? 'N/A' }}</td>
                            <td>{{ $student->mobile }}</td>
                            <td>{{ $student->category ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-center text-muted">
            <p>Total Students: <strong>{{ $students->count() }}</strong></p>
        </div>
    @endif
</body>
</html>
