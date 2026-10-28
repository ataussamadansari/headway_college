@extends('layouts.app')

@section('title', 'Course Details - Student ERP')

@section('content')
<div class="page-title">
    <i class="fas fa-book"></i>
    <div>
        <h1 style="margin: 0; color: var(--primary-color);">{{ $course->name }}</h1>
    </div>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
        <li class="breadcrumb-item active">{{ $course->name }}</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Course Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Course Code</label>
                        <p class="h5">{{ $course->code }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <p>
                            @if ($course->is_active)
                                <span class="badge bg-success"><i class="fas fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Inactive</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Duration</label>
                        <p class="h5">{{ $course->duration ?? 'Not specified' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Total Seats</label>
                        <p class="h5">{{ $course->total_seats }}</p>
                    </div>
                </div>

                @if ($course->description)
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <p>{{ $course->description }}</p>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Created At</label>
                    <p class="text-muted">{{ $course->created_at->format('d M Y, H:i A') }}</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-users"></i> Students Enrolled</h5>
            </div>
            <div class="card-body">
                <div class="stat-number">{{ $course->students->count() }}/{{ $course->total_seats }}</div>
                <small class="text-muted">
                    {{ $course->total_seats > 0 ? round(($course->students->count() / $course->total_seats) * 100) : 0 }}% Filled
                </small>
                <div class="progress mt-3" style="height: 25px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $course->total_seats > 0 ? round(($course->students->count() / $course->total_seats) * 100) : 0 }}%;">
                        {{ $course->total_seats > 0 ? round(($course->students->count() / $course->total_seats) * 100) : 0 }}%
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
