@extends('layouts.app')

@section('title', 'Sessions - Student ERP')

@section('content')
<div class="page-title">
    <i class="fas fa-calendar"></i>
    <div>
        <h1 style="margin: 0; color: var(--primary-color);">Sessions</h1>
    </div>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Sessions</li>
    </ol>
</nav>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Session List</h5>
        <a href="{{ route('sessions.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Add New Session
        </a>
    </div>
    <div class="card-body">
        @if ($sessions->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No sessions found. <a href="{{ route('sessions.create') }}">Create one</a></p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Session Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessions as $session)
                            <tr>
                                <td>
                                    <strong>{{ $session->name }}</strong>
                                </td>
                                <td>{{ $session->start_date->format('d M Y') }}</td>
                                <td>{{ $session->end_date->format('d M Y') }}</td>
                                <td>
                                    @if ($session->is_active)
                                        <span class="badge bg-success"><i class="fas fa-check-circle"></i> Active</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('sessions.show', $session) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('sessions.edit', $session) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('sessions.destroy', $session) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
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
                {{ $sessions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
