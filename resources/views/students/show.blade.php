@extends('layouts.app')

@section('title', 'Student Details - Student ERP')

@section('content')
<div class="page-title">
    <i class="fas fa-user"></i>
    <div>
        <h1 style="margin: 0; color: var(--primary-color);">{{ $student->name }}</h1>
        <small style="color: #666;">Register No: {{ $student->college_register_no }}</small>
    </div>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
        <li class="breadcrumb-item active">{{ $student->name }}</li>
    </ol>
</nav>

<div class="row">
    <!-- Main Student Details -->
    <div class="col-md-8">
        <!-- Registration Details -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Registration Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label"><strong>Register No</strong></label>
                        <p>{{ $student->college_register_no }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>Control No</strong></label>
                        <p>{{ $student->control_no }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>Registration Date</strong></label>
                        <p>{{ $student->registration_date->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Course</strong></label>
                        <p>{{ $student->course->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><strong>Session</strong></label>
                        <p>{{ $student->session->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Details -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user"></i> Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Student Name</strong></label>
                        <p>{{ $student->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><strong>Date of Birth</strong></label>
                        <p>{{ $student->dob->format('d M Y') }} ({{ $student->dob->diffInYears(now()) }} years)</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Father Name</strong></label>
                        <p>{{ $student->father_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><strong>Mother Name</strong></label>
                        <p>{{ $student->mother_name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label"><strong>Gender</strong></label>
                        <p>{{ ucfirst($student->gender) }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><strong>Religion</strong></label>
                        <p>{{ $student->religion ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><strong>Category</strong></label>
                        <p>{{ $student->category ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><strong>Handicap</strong></label>
                        <p>
                            @if($student->is_handicap)
                                <span class="badge bg-warning">Yes</span>
                            @else
                                <span class="badge bg-success">No</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Domicile in UP</strong></label>
                        <p>
                            @if($student->domicile_up)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Details -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-phone"></i> Contact Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Mobile Number</strong></label>
                        <p><a href="tel:{{ $student->mobile }}">{{ $student->mobile }}</a></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><strong>Pincode</strong></label>
                        <p>{{ $student->pincode }}</p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Address</strong></label>
                    <p>{{ $student->address }}</p>
                </div>
            </div>
        </div>

        <!-- Educational Qualifications -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-book"></i> Educational Qualifications</h5>
            </div>
            <div class="card-body">
                @if($student->educationalQualifications->isEmpty())
                    <p class="text-muted text-center py-4">No educational qualifications added yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Qualification</th>
                                    <th>Board/University</th>
                                    <th>Stream</th>
                                    <th>Year</th>
                                    <th>Roll No</th>
                                    <th>Obtained/Max</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->educationalQualifications as $qual)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info">
                                                {{
                                                    $qual->qualification_type === 'highschool' ? '10th (High School)' :
                                                    ($qual->qualification_type === 'intermediate' ? '12th (Intermediate)' :
                                                    ($qual->qualification_type === 'ug' ? 'UG' : ucfirst(str_replace('_', ' ', $qual->qualification_type))))
                                                }}
                                            </span>
                                        </td>
                                        <td>{{ $qual->board_university }}</td>
                                        <td>{{ $qual->stream }}</td>
                                        <td>{{ $qual->year_of_completion }}</td>
                                        <td>{{ $qual->roll_number }}</td>
                                        <td>{{ $qual->obtained_marks }}/{{ $qual->max_marks }}</td>
                                        <td>
                                            <strong>
                                                @if ($qual->percentage)
                                                    {{ number_format($qual->percentage, 2) }}%
                                                @elseif ($qual->max_marks && $qual->obtained_marks)
                                                    {{ number_format(($qual->obtained_marks / $qual->max_marks) * 100, 2) }}%
                                                @else
                                                    -
                                                @endif
                                            </strong>
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

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Photo -->
        @if($student->photo_path)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-image"></i> Photo</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $student->photo_url }}" alt="Photo" class="img-fluid" style="max-width: 200px; border-radius: 8px;">
                </div>
            </div>
        @endif

        <!-- Signature -->
        @if($student->signature_path)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-signature"></i> Signature</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $student->signature_url }}" alt="Signature" class="img-fluid" style="max-width: 150px;">
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cog"></i> Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit Student
                    </a>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Registration Summary -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Timestamps</h5>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>Created:</strong> {{ $student->created_at->format('d M Y, H:i A') }}<br>
                    <strong>Last Updated:</strong> {{ $student->updated_at->format('d M Y, H:i A') }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
