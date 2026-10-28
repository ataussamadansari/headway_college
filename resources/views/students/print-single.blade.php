<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Record - {{ $student->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.35;
            color: #333;
        }
        @media print {
            @page {
                size: A4;
                margin: 4mm;
            }

            body {
                margin: 0;
                padding: 4mm;
            }
        }
        .container {
            max-width: 900px;
            margin: 10px auto;
            padding: 14px;
            border: 1px solid #ddd;
            background-color: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #0D47A1;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }
        .brand-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .brand-logo {
            width: 52px;
            height: 52px;
            object-fit: cover;
            border: 1px solid #cfd8dc;
            border-radius: 6px;
            padding: 2px;
            background: #fff;
        }
        .header h1 {
            color: #0D47A1;
            margin: 4px 0;
            font-size: 20px;
        }
        .header p {
            color: #666;
            font-size: 11px;
            margin: 2px 0;
        }
        .documents-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            align-items: start;
        }
        .document-box {
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px;
            min-height: 128px;
        }
        .document-box img {
            max-height: 110px;
            max-width: 100%;
            object-fit: contain;
        }
        .section {
            margin-bottom: 12px;
        }
        .section-title {
            background-color: #0D47A1;
            color: white;
            padding: 6px 10px;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 12px;
            border-radius: 3px;
        }
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 8px;
        }
        .row.full {
            grid-template-columns: 1fr;
        }
        .field {
            padding-bottom: 6px;
            border-bottom: 1px solid #eee;
        }
        .field-label {
            font-weight: bold;
            color: #0D47A1;
            font-size: 10px;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .field-value {
            font-size: 12px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        table th {
            background-color: #1565C0;
            color: white;
            padding: 6px;
            text-align: left;
            font-size: 10px;
            border: 1px solid #0D47A1;
        }
        table td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .print-button {
            text-align: center;
            margin-top: 12px;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }
        .print-button button {
            background-color: #0D47A1;
            color: white;
            padding: 8px 18px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin: 0 10px;
        }
        .bottom-sign-lines {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 18px;
            margin-top: 8px;
            text-align: center;
        }
        .bottom-sign-lines .line {
            border-top: 1px solid #333;
            padding-top: 6px;
            font-weight: bold;
            font-size: 11px;
        }
        .print-button button:hover {
            background-color: #1565C0;
        }
        @media print {
            .print-button {
                display: none;
            }
            .container {
                border: none;
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
            body {
                padding: 0;
                margin: 0;
            }
            .section,
            table,
            .documents-section,
            .bottom-sign-lines {
                page-break-inside: avoid;
            }
        }
        @media (max-width: 600px) {
            .brand-header {
                flex-direction: column;
                gap: 6px;
            }
            .brand-logo {
                width: 46px;
                height: 46px;
            }
            .documents-section {
                grid-template-columns: 1fr;
            }
            .bottom-sign-lines {
                grid-template-columns: 1fr;
            }
            table th, table td {
                font-size: 11px;
                padding: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="brand-header">
                <img src="{{ asset('img/headway%20logo.jpeg') }}" alt="Headway College Logo" class="brand-logo">
                <div>
                    <h1>HEADWAY COLLEGE</h1>
                    <p>Student Record</p>
                    <p>Generated on {{ now()->format('d M Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Registration Details -->
        <div class="section">
            <div class="section-title">Registration Details</div>
            <div class="row">
                <div class="field">
                    <div class="field-label">College Register No</div>
                    <div class="field-value">{{ $student->college_register_no }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Control No</div>
                    <div class="field-value">{{ $student->control_no }}</div>
                </div>
            </div>
            <div class="row">
                <div class="field">
                    <div class="field-label">Registration Date</div>
                    <div class="field-value">{{ $student->registration_date->format('d/m/Y') }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Course</div>
                    <div class="field-value">{{ $student->course->name ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="row">
                <div class="field">
                    <div class="field-label">Session</div>
                    <div class="field-value">{{ $student->session->name ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="section">
            <div class="section-title">Personal Information</div>
            <div class="row">
                <div class="field">
                    <div class="field-label">Student Name</div>
                    <div class="field-value">{{ $student->name }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Father Name</div>
                    <div class="field-value">{{ $student->father_name }}</div>
                </div>
            </div>
            <div class="row">
                <div class="field">
                    <div class="field-label">Mother Name</div>
                    <div class="field-value">{{ $student->mother_name }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Date of Birth</div>
                    <div class="field-value">{{ $student->dob->format('d/m/Y') }}</div>
                </div>
            </div>
            <div class="row">
                <div class="field">
                    <div class="field-label">Gender</div>
                    <div class="field-value">{{ ucfirst($student->gender) }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Religion</div>
                    <div class="field-value">{{ $student->religion ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="row">
                <div class="field">
                    <div class="field-label">Category</div>
                    <div class="field-value">{{ $student->category ?? 'N/A' }}</div>
                </div>
                <!-- <div class="field">
                    <div class="field-label">Caste</div>
                    <div class="field-value">{{ $student->caste ?? 'N/A' }}</div>
                </div> -->
            </div>
            <div class="row full">
                <div class="field">
                    <div class="field-label">Additional Info</div>
                    <div class="field-value">
                        @if ($student->domicile_up)
                            <span style="background-color: #e0e0e0; padding: 2px 8px; border-radius: 3px; margin-right: 10px;">Domicile in UP</span>
                        @endif
                        @if ($student->is_handicap)
                            <span style="background-color: #e0e0e0; padding: 2px 8px; border-radius: 3px;">Handicap</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Details -->
        <div class="section">
            <div class="section-title">Contact Details</div>
            <div class="row">
                <div class="field">
                    <div class="field-label">Mobile Number</div>
                    <div class="field-value">{{ $student->mobile }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Pincode</div>
                    <div class="field-value">{{ $student->pincode }}</div>
                </div>
            </div>
            <div class="row full">
                <div class="field">
                    <div class="field-label">Address</div>
                    <div class="field-value">{{ $student->address }}</div>
                </div>
            </div>
        </div>

        <!-- Educational Qualifications -->
        <div class="section">
            <div class="section-title">Educational Qualifications</div>

            @if ($student->educationalQualifications->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Qualification</th>
                            <th>Board/University</th>
                            <th>Stream</th>
                            <th>Year</th>
                            <th>Roll No</th>
                            <th>Max Marks</th>
                            <th>Obtained Marks</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student->educationalQualifications as $qual)
                            <tr>
                                <td>
                                    {{
                                        $qual->qualification_type === 'highschool' ? '10th (High School)' :
                                        ($qual->qualification_type === 'intermediate' ? '12th (Intermediate)' :
                                        ($qual->qualification_type === 'ug' ? 'UG' : ucfirst(str_replace('_', ' ', $qual->qualification_type))))
                                    }}
                                </td>
                                <td>{{ $qual->board_university }}</td>
                                <td>{{ $qual->stream }}</td>
                                <td>{{ $qual->year_of_completion }}</td>
                                <td>{{ $qual->roll_number ?? '-' }}</td>
                                <td>{{ $qual->max_marks ?? '-' }}</td>
                                <td>{{ $qual->obtained_marks ?? '-' }}</td>
                                <td>
                                    @if ($qual->percentage)
                                        {{ number_format($qual->percentage, 2) }}%
                                    @else
                                        {{ $qual->max_marks && $qual->obtained_marks ? number_format(($qual->obtained_marks / $qual->max_marks) * 100, 2) . '%' : '-' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="border: 1px solid #ddd; padding: 12px; border-radius: 4px; color: #666; font-size: 13px;">
                    No educational qualification details available.
                </div>
            @endif
        </div>

        <!-- Bottom Photo & Signature -->
        <div class="section">
            <div class="section-title">Photo & Uploaded Signature</div>
            <div class="documents-section">
                <div class="document-box">
                    <div class="field-label" style="text-align: center; margin-bottom: 6px;">Student Photo</div>
                    @if ($student->photo_path)
                        <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Student Photo">
                    @else
                        <div style="color: #999; font-size: 11px; padding-top: 32px;">No photo uploaded</div>
                    @endif
                </div>
                <div class="document-box">
                    <div class="field-label" style="text-align: center; margin-bottom: 6px;">Student Signature</div>
                    @if ($student->signature_path)
                        <img src="{{ asset('storage/' . $student->signature_path) }}" alt="Signature">
                    @else
                        <div style="color: #999; font-size: 11px; padding-top: 32px;">No signature uploaded</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Signature Lines -->
        <div class="section">
            <div class="bottom-sign-lines">
                <div>
                    <div class="line">Student Signature</div>
                </div>
                <div>
                    <div class="line">Parent/Guardian Signature</div>
                </div>
                <div>
                    <div class="line">Official Stamp</div>
                </div>
            </div>
        </div>

        <!-- Print Button -->
        <div class="print-button">
            <button onclick="window.print()">Print Record</button>
            <button onclick="window.history.back()">Back</button>
        </div>
    </div>
</body>
</html>
