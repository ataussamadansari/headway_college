@extends('layouts.app')

@section('title', 'Courses - Student ERP')

@section('content')
<div class="page-title">
    <i class="fas fa-book"></i>
    <div>
        <h1 style="margin: 0; color: var(--primary-color);">Courses</h1>
    </div>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Courses</li>
    </ol>
</nav>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Course List</h5>
        <a href="{{ route('courses.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Add New Course
        </a>
    </div>
    <div class="card-body">
        @if ($courses->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No courses found. <a href="{{ route('courses.create') }}">Create one</a></p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Duration</th>
                            <th>Total Seats</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $course->code }}</span>
                                </td>
                                <td>
                                    <strong>{{ $course->name }}</strong>
                                </td>
                                <td>{{ $course->duration ?? 'N/A' }}</td>
                                <td>{{ $course->total_seats }}</td>
                                <td>
                                    @if ($course->is_active)
                                        <span class="badge bg-success"><i class="fas fa-check-circle"></i> Active</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
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
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
