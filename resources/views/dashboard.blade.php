@extends('layouts.app')

@section('title', 'Dashboard - Student ERP')

@section('content')
<div class="page-title">
    <i class="fas fa-chart-bar"></i>
    <div>
        <h1 style="margin: 0; color: var(--primary-color);">Dashboard</h1>
        <small style="color: #666;">Welcome to Headway College Student ERP System</small>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <h3><i class="fas fa-users"></i> Total Students</h3>
            <div class="stat-number">{{ $totalStudents }}</div>
            <small class="text-muted">Registered students</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <h3><i class="fas fa-book"></i> Courses</h3>
            <div class="stat-number">{{ $totalCourses }}</div>
            <small class="text-muted">{{ $activeCourses }} active</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <h3><i class="fas fa-calendar"></i> Sessions</h3>
            <div class="stat-number">{{ $totalSessions }}</div>
            <small class="text-muted">{{ $activeSessions }} active</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <h3><i class="fas fa-chart-line"></i> Growth</h3>
            <div class="stat-number">{{ $totalStudents > 0 ? round(($totalStudents / max(1, $totalCourses)) * 100) : 0 }}%</div>
            <small class="text-muted">Avg per course</small>
        </div>
    </div>
</div>

<div class="row">
    <!-- Students by Course -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-book"></i> Students by Course</h5>
            </div>
            <div class="card-body">
                @if ($studentsByCourse->isEmpty())
                    <p class="text-muted text-center py-4">No courses found</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Students</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $maxStudents = $studentsByCourse->max('students_count') ?? 1; @endphp
                                @foreach ($studentsByCourse as $course)
                                    @php $percentage = ($course->students_count / max(1, $course->total_seats)) * 100; @endphp
                                    <tr>
                                        <td>{{ $course->name }}</td>
                                        <td><span class="badge bg-info">{{ $course->students_count }}/{{ $course->total_seats }}</span></td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" style="width: {{ min($percentage, 100) }}%;">
                                                    {{ number_format($percentage, 0) }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Students by Session -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar"></i> Students by Session</h5>
            </div>
            <div class="card-body">
                @if ($studentsBySession->isEmpty())
                    <p class="text-muted text-center py-4">No sessions found</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Session</th>
                                    <th>Students</th>
                                    <th>Date Range</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studentsBySession as $session)
                                    <tr>
                                        <td>{{ $session->name }}</td>
                                        <td><span class="badge bg-primary">{{ $session->students_count }}</span></td>
                                        <td>
                                            <small>{{ $session->start_date->format('d M') }} - {{ $session->end_date->format('d M Y') }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Students -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Recent Students</h5>
            </div>
            <div class="card-body">
                @if ($recentStudents->isEmpty())
                    <p class="text-muted text-center py-4">No students registered yet</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Register No</th>
                                    <th>Student Name</th>
                                    <th>Course</th>
                                    <th>Session</th>
                                    <th>Mobile</th>
                                    <th>Registration Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentStudents as $student)
                                    <tr>
                                        <td><span class="badge bg-light text-dark">{{ $student->college_register_no }}</span></td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->course->name ?? 'N/A' }}</td>
                                        <td>{{ $student->session->name ?? 'N/A' }}</td>
                                        <td>{{ $student->mobile }}</td>
                                        <td>{{ $student->registration_date->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-lightning-bolt"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('students.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Register New Student
                    </a>
                    <a href="{{ route('courses.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Add Course
                    </a>
                    <a href="{{ route('sessions.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Add Session
                    </a>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list"></i> View All Students
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
