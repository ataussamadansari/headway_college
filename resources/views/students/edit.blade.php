@extends('layouts.app')

@section('title', 'Edit Student - Student ERP')

@push('styles')
<style>
    .qualification-row {
        border: 1px solid #e0e0e0;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        background-color: #f9f9f9;
    }
</style>
@endpush

@section('content')
<div class="page-title">
    <i class="fas fa-edit"></i>
    <div>
        <h1 style="margin: 0; color: var(--primary-color);">Edit Student Information</h1>
    </div>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>

@php
    $existingQualifications = old('educational_qualifications')
        ? json_decode(old('educational_qualifications'), true)
        : $student->educationalQualifications->map(function ($qualification) {
            return [
                'qualification_type' => $qualification->qualification_type,
                'board_university' => $qualification->board_university,
                'stream' => $qualification->stream,
                'year_of_completion' => $qualification->year_of_completion,
                'roll_number' => $qualification->roll_number,
                'max_marks' => $qualification->max_marks,
                'obtained_marks' => $qualification->obtained_marks,
            ];
        })->values()->toArray();

    if (!is_array($existingQualifications)) {
        $existingQualifications = [];
    }
@endphp

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Student Details - {{ $student->name }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Registration Details -->
            <div class="mb-4">
                <h5 style="color: var(--primary-color); border-bottom: 2px solid var(--primary-color); padding-bottom: 10px;">
                    <i class="fas fa-info-circle"></i> Registration Details
                </h5>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="college_register_no" class="form-label">College Register No <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('college_register_no') is-invalid @enderror" id="college_register_no" name="college_register_no" value="{{ old('college_register_no', $student->college_register_no) }}" required>
                            @error('college_register_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="control_no" class="form-label">Control No <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('control_no') is-invalid @enderror" id="control_no" name="control_no" value="{{ old('control_no', $student->control_no) }}" required>
                            @error('control_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="registration_date" class="form-label">Registration Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('registration_date') is-invalid @enderror" id="registration_date" name="registration_date" value="{{ old('registration_date', $student->registration_date->format('Y-m-d')) }}" required>
                            @error('registration_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                            <select class="form-select @error('course_id') is-invalid @enderror" id="course_id" name="course_id" required>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', $student->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="session_id" class="form-label">Session <span class="text-danger">*</span></label>
                            <select class="form-select @error('session_id') is-invalid @enderror" id="session_id" name="session_id" required>
                                @foreach($sessions as $session)
                                    <option value="{{ $session->id }}" {{ old('session_id', $student->session_id) == $session->id ? 'selected' : '' }}>
                                        {{ $session->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('session_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Details -->
            <div class="mb-4">
                <h5 style="color: var(--primary-color); border-bottom: 2px solid var(--primary-color); padding-bottom: 10px;">
                    <i class="fas fa-user"></i> Personal Information
                </h5>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Student Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $student->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="father_name" class="form-label">Father Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('father_name') is-invalid @enderror" id="father_name" name="father_name" value="{{ old('father_name', $student->father_name) }}" required>
                            @error('father_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="mother_name" class="form-label">Mother Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('mother_name') is-invalid @enderror" id="mother_name" name="mother_name" value="{{ old('mother_name', $student->mother_name) }}" required>
                            @error('mother_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob', $student->dob->format('Y-m-d')) }}" required>
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="gender_male" name="gender" value="male" {{ old('gender', $student->gender) == 'male' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="gender_male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="gender_female" name="gender" value="female" {{ old('gender', $student->gender) == 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender_female">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="gender_other" name="gender" value="other" {{ old('gender', $student->gender) == 'other' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender_other">Other</label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="religion" class="form-label">Religion</label>
                            <input type="text" class="form-control @error('religion') is-invalid @enderror" id="religion" name="religion" value="{{ old('religion', $student->religion) }}">
                            @error('religion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category', $student->category) }}">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="domicile_up" name="domicile_up" value="1" {{ old('domicile_up', $student->domicile_up) ? 'checked' : '' }}>
                                <label class="form-check-label" for="domicile_up">Domicile in UP</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_handicap" name="is_handicap" value="1" {{ old('is_handicap', $student->is_handicap) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_handicap">Is Handicap</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Details -->
            <div class="mb-4">
                <h5 style="color: var(--primary-color); border-bottom: 2px solid var(--primary-color); padding-bottom: 10px;">
                    <i class="fas fa-phone"></i> Contact Details
                </h5>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile', $student->mobile) }}" required>
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pincode') is-invalid @enderror" id="pincode" name="pincode" value="{{ old('pincode', $student->pincode) }}" required>
                            @error('pincode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $student->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Photo & Signature -->
            <div class="mb-4">
                <h5 style="color: var(--primary-color); border-bottom: 2px solid var(--primary-color); padding-bottom: 10px;">
                    <i class="fas fa-image"></i> Documents
                </h5>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            @if($student->photo_path)
                                <div class="mb-2">
                                    <img src="{{ $student->photo_url }}" alt="Photo" style="max-width: 100px; max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                            <small class="text-muted">JPEG, PNG, JPG, GIF (Max 2MB)</small>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="signature" class="form-label">Signature</label>
                            @if($student->signature_path)
                                <div class="mb-2">
                                    <img src="{{ $student->signature_url }}" alt="Signature" style="max-width: 100px; max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('signature') is-invalid @enderror" id="signature" name="signature" accept="image/*">
                            <small class="text-muted">JPEG, PNG, JPG, GIF (Max 2MB)</small>
                            @error('signature')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Educational Qualifications -->
            <div class="mb-4">
                <h5 style="color: var(--primary-color); border-bottom: 2px solid var(--primary-color); padding-bottom: 10px;">
                    <i class="fas fa-graduation-cap"></i> Educational Qualifications
                </h5>

                <div id="qualifications-container" class="mt-3"></div>

                <button type="button" class="btn btn-light btn-sm" id="add-qualification">
                    <i class="fas fa-plus"></i> Add Qualification
                </button>
            </div>

            <input
                type="hidden"
                id="qualifications-json"
                name="educational_qualifications"
                value="{{ old('educational_qualifications', '') }}"
            >

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Student
                </button>
                <a href="{{ route('students.show', $student) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const existingQualifications = @json($existingQualifications);
    const qualificationsContainer = document.getElementById('qualifications-container');
    const qualificationsJsonInput = document.getElementById('qualifications-json');
    const addQualificationButton = document.getElementById('add-qualification');

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function qualificationOptions(selectedType) {
        return `
            <option value="">Select Type</option>
            <option value="highschool" ${selectedType === 'highschool' ? 'selected' : ''}>10th (High School)</option>
            <option value="intermediate" ${selectedType === 'intermediate' ? 'selected' : ''}>12th (Intermediate)</option>
            <option value="ug" ${selectedType === 'ug' ? 'selected' : ''}>UG</option>
        `;
    }

    function addQualificationRow(qualification = {}) {
        const row = document.createElement('div');
        row.className = 'qualification-row';
        row.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Qualification Type <span class="text-danger">*</span></label>
                    <select class="form-select qualification-field" data-field="qualification_type" required>
                        ${qualificationOptions(qualification.qualification_type || '')}
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Board/University <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        class="form-control qualification-field"
                        data-field="board_university"
                        value="${escapeHtml(qualification.board_university || '')}"
                        required
                    >
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stream/Subject <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        class="form-control qualification-field"
                        data-field="stream"
                        value="${escapeHtml(qualification.stream || '')}"
                        required
                    >
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-3">
                    <label class="form-label">Year of Completion <span class="text-danger">*</span></label>
                    <input
                        type="number"
                        class="form-control qualification-field"
                        data-field="year_of_completion"
                        min="1990"
                        max="${new Date().getFullYear()}"
                        value="${escapeHtml(qualification.year_of_completion || '')}"
                        required
                    >
                </div>
                <div class="col-md-3">
                    <label class="form-label">Roll Number <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        class="form-control qualification-field"
                        data-field="roll_number"
                        value="${escapeHtml(qualification.roll_number || '')}"
                        required
                    >
                </div>
                <div class="col-md-3">
                    <label class="form-label">Max Marks <span class="text-danger">*</span></label>
                    <input
                        type="number"
                        class="form-control qualification-field"
                        data-field="max_marks"
                        min="0"
                        value="${escapeHtml(qualification.max_marks || '')}"
                        required
                    >
                </div>
                <div class="col-md-3">
                    <label class="form-label">Obtained Marks <span class="text-danger">*</span></label>
                    <input
                        type="number"
                        class="form-control qualification-field"
                        data-field="obtained_marks"
                        min="0"
                        value="${escapeHtml(qualification.obtained_marks || '')}"
                        required
                    >
                </div>
            </div>

            <div class="mt-3 text-end">
                <button type="button" class="btn btn-sm btn-outline-danger remove-qualification">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
        `;

        row.querySelector('.remove-qualification').addEventListener('click', function () {
            row.remove();
            syncQualificationJson();
        });

        row.querySelectorAll('.qualification-field').forEach(function (field) {
            field.addEventListener('input', syncQualificationJson);
            field.addEventListener('change', syncQualificationJson);
        });

        qualificationsContainer.appendChild(row);
        syncQualificationJson();
    }

    function syncQualificationJson() {
        const rows = qualificationsContainer.querySelectorAll('.qualification-row');
        const data = Array.from(rows).map(function (row) {
            return {
                qualification_type: row.querySelector('[data-field="qualification_type"]').value,
                board_university: row.querySelector('[data-field="board_university"]').value,
                stream: row.querySelector('[data-field="stream"]').value,
                year_of_completion: row.querySelector('[data-field="year_of_completion"]').value,
                roll_number: row.querySelector('[data-field="roll_number"]').value,
                max_marks: row.querySelector('[data-field="max_marks"]').value,
                obtained_marks: row.querySelector('[data-field="obtained_marks"]').value,
            };
        });

        qualificationsJsonInput.value = JSON.stringify(data);
    }

    addQualificationButton.addEventListener('click', function () {
        addQualificationRow();
    });

    if (Array.isArray(existingQualifications) && existingQualifications.length > 0) {
        existingQualifications.forEach(function (qualification) {
            addQualificationRow(qualification);
        });
    } else {
        addQualificationRow();
    }

    document.querySelector('form').addEventListener('submit', function () {
        syncQualificationJson();
    });
</script>
@endsection
