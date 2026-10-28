@extends('layouts.app')

@section('title', 'Session Details - Student ERP')

@section('content')
<div class="page-title">
    <i class="fas fa-calendar"></i>
    <div>
        <h1 style="margin: 0; color: var(--primary-color);">{{ $session->name }}</h1>
    </div>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sessions.index') }}">Sessions</a></li>
        <li class="breadcrumb-item active">{{ $session->name }}</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Session Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Session Name</label>
                        <p class="h5">{{ $session->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <p>
                            @if ($session->is_active)
                                <span class="badge bg-success"><i class="fas fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Inactive</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Start Date</label>
                        <p class="h5">{{ $session->start_date->format('d M Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">End Date</label>
                        <p class="h5">{{ $session->end_date->format('d M Y') }}</p>
                    </div>
                </div>

                @if ($session->remarks)
                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <p>{{ $session->remarks }}</p>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Created At</label>
                    <p class="text-muted">{{ $session->created_at->format('d M Y, H:i A') }}</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('sessions.edit', $session) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('sessions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <form action="{{ route('sessions.destroy', $session) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
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
                <h5 class="mb-0"><i class="fas fa-users"></i> Students</h5>
            </div>
            <div class="card-body">
                <div class="stat-number">{{ $session->students->count() }}</div>
                <small class="text-muted">Students in this session</small>
            </div>
        </div>
    </div>
</div>
@endsection
