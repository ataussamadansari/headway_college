@extends('layouts.app')

@section('title', 'Students - Student ERP')

@section('content')
<div class="page-title">
    <i class="fas fa-users"></i>
    <div>
        <h1 style="margin: 0; color: var(--primary-color);">Students</h1>
    </div>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Students</li>
    </ol>
</nav>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Student List</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('students.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-user-plus"></i> Register Student
            </a>
            <a href="{{ route('students.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-light btn-sm" title="Export to Excel">
                <i class="fas fa-file-excel"></i> Export
            </a>
            <a href="{{ route('students.print') }}?{{ http_build_query(request()->all()) }}" class="btn btn-light btn-sm" target="_blank" title="Print">
                <i class="fas fa-print"></i> Print
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filters -->
        <form method="GET" action="{{ route('students.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by name, register no, mobile..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="course_id" class="form-select">
                        <option value="">All Courses</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="session_id" class="form-select">
                        <option value="">All Sessions</option>
                        @foreach($sessions as $session)
                            <option value="{{ $session->id }}" {{ request('session_id') == $session->id ? 'selected' : '' }}>
                                {{ $session->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        @if ($students->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No students found. <a href="{{ route('students.create') }}">Register one</a></p>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                Showing <strong>{{ $students->firstItem() }}-{{ $students->lastItem() }}</strong> of <strong>{{ $students->total() }}</strong> students
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Register No</th>
                            <th>Student Name</th>
                            <th>Father Name</th>
                            <th>Course</th>
                            <th>Session</th>
                            <th>Gender</th>
                            <th>Mobile</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td><span class="badge bg-light text-dark">{{ $student->college_register_no }}</span></td>
                                <td><strong>{{ $student->name }}</strong></td>
                                <td>{{ $student->father_name }}</td>
                                <td>{{ $student->course->name ?? 'N/A' }}</td>
                                <td>{{ $student->session->name ?? 'N/A' }}</td>
                                <td>{{ ucfirst($student->gender) }}</td>
                                <td>{{ $student->mobile }}</td>
                                <td>
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('students.print-single', $student) }}" class="btn btn-sm btn-success" title="Print" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-4">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
