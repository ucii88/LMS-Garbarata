<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion</title>
    <style>
        @page { margin: 0; size: A4 landscape; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #ffffff;
            color: #1a1a2e;
        }

        .page {
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
            display: flex;
        }

        /* Left sidebar */
        .sidebar {
            width: 52mm;
            height: 210mm;
            background: {{ $primary_color }};
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10mm 6mm;
            flex-shrink: 0;
        }
        .sidebar-logo {
            max-width: 30mm;
            max-height: 14mm;
            object-fit: contain;
            margin-bottom: 5mm;
            filter: brightness(0) invert(1);
        }
        .sidebar-divider {
            width: 20mm;
            border: none;
            border-top: 1px solid rgba(255,255,255,.4);
            margin: 4mm 0;
        }
        .sidebar-org {
            font-size: 7.5pt;
            font-weight: bold;
            color: rgba(255,255,255,.95);
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
            line-height: 1.5;
        }
        .sidebar-icon {
            font-size: 28pt;
            color: rgba(255,255,255,.3);
            margin-bottom: 4mm;
        }

        /* Right content */
        .content {
            flex: 1;
            padding: 14mm 16mm 12mm 14mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        /* Subtle accent line at top */
        .accent-line {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4mm;
            background: {{ $secondary_color }};
        }

        /* Top section */
        .top-section { margin-top: 6mm; }
        .cert-label {
            font-size: 7.5pt;
            font-weight: bold;
            color: {{ $primary_color }};
            text-transform: uppercase;
            letter-spacing: 5px;
            margin-bottom: 1mm;
        }
        .cert-title {
            font-size: 26pt;
            font-weight: bold;
            color: #1a1a2e;
            line-height: 1.1;
            margin-bottom: 0.5mm;
        }
        .cert-subtitle {
            font-size: 12pt;
            color: {{ $secondary_color }};
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: bold;
        }

        /* Name accent bar */
        .name-bar {
            width: 12mm;
            height: 2.5px;
            background: {{ $primary_color }};
            margin: 5mm 0 2mm 0;
        }

        /* Student name */
        .presented-label {
            font-size: 8pt;
            color: #64748b;
            margin-bottom: 1.5mm;
            letter-spacing: 1px;
        }
        .student-name {
            font-size: 28pt;
            font-weight: bold;
            color: #1a1a2e;
            font-family: DejaVu Serif, serif;
            line-height: 1.15;
            margin-bottom: 3mm;
        }

        /* Course info */
        .course-section { margin-bottom: 4mm; }
        .course-label {
            font-size: 7.5pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5mm;
        }
        .course-name {
            font-size: 13pt;
            font-weight: bold;
            color: #1a1a2e;
            margin-bottom: 1mm;
        }
        .score-line {
            font-size: 8.5pt;
            color: #475569;
        }
        .score-val { font-weight: bold; color: #059669; font-size: 10pt; }

        /* Bottom row */
        .bottom-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            border-top: 1px solid #e2e8f0;
            padding-top: 3mm;
        }
        .meta-block { font-size: 7.5pt; color: #94a3b8; }
        .meta-block strong { color: #334155; display: block; font-size: 8.5pt; }

        /* Signature block */
        .sig-block { text-align: center; min-width: 38mm; }
        .sig-img   { height: 18mm; max-width: 52mm; object-fit: contain; display: block; margin: 0 auto 1mm auto; }
        .sig-space { height: 18mm; }
        .sig-line  { border-bottom: 1px solid #cbd5e1; width: 36mm; margin: 0 auto 1mm auto; }
        .sig-name  { font-size: 7.5pt; font-weight: bold; color: #334155; }
        .sig-title { font-size: 6.5pt; color: #94a3b8; }

        .sig-group { display: flex; gap: 8mm; align-items: flex-end; }
    </style>
</head>
<body>
<div class="page">

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="sidebar-icon">&#9670;</div>
        @if (!empty($logo_data_uri))
            <img src="{{ $logo_data_uri }}" alt="" class="sidebar-logo">
        @endif
        <hr class="sidebar-divider">
        <div class="sidebar-org">{{ $organization_name }}</div>
    </div>

    {{-- Content --}}
    <div class="content">
        <div class="accent-line"></div>

        {{-- Top --}}
        <div class="top-section">
            <div class="cert-label">{{ __('Sertifikat') }}</div>
            <div class="cert-title">Certificate</div>
            <div class="cert-subtitle">of Completion</div>
        </div>

        {{-- Middle --}}
        <div>
            <div class="name-bar"></div>
            <div class="presented-label">{{ __('Diberikan kepada:') }}</div>
            <div class="student-name">{{ $student_name }}</div>
            <div class="course-section">
                <div class="course-label">{{ __('Kursus') }}</div>
                <div class="course-name">{{ $course_name }}</div>
                <div class="score-line">
                    {{ __('Nilai:') }} <span class="score-val">{{ number_format($total_score, 1) }}</span> / 100
                </div>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="bottom-row">
            <div>
                <div class="meta-block">
                    {{ __('Tanggal Diterbitkan') }}
                    <strong>{{ $issued_date }}</strong>
                </div>
                <div class="meta-block" style="margin-top:2mm;">
                    {{ __('Kode Verifikasi') }}
                    <strong style="font-family: DejaVu Sans Mono, monospace; letter-spacing:1px;">{{ $certificate_code }}</strong>
                </div>
            </div>

            <div class="sig-group">
                <div class="sig-block">
                    @if (!empty($instructor_signature_url))
                        <img src="{{ $instructor_signature_url }}" alt="" class="sig-img">
                    @else
                        <div class="sig-space"></div>
                    @endif
                    <div class="sig-line"></div>
                    <div class="sig-name">{{ $instructor_name ?? __('Instruktur') }}</div>
                    <div class="sig-title">{{ __('Instruktur') }}</div>
                </div>
                <div class="sig-block">
                    @if (!empty($kepala_signature_url))
                        <img src="{{ $kepala_signature_url }}" alt="" class="sig-img">
                    @else
                        <div class="sig-space"></div>
                    @endif
                    <div class="sig-line"></div>
                    <div class="sig-name">{{ $kepala_name ?? __('Kepala Training') }}</div>
                    <div class="sig-title">{{ $kepala_title ?? $organization_name }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
