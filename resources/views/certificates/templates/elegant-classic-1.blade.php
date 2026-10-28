<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion</title>
    <style>
        @page { margin: 0; size: A4 landscape; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: DejaVu Serif, serif;
            background: #fdf8ee;
            color: #1a1208;
        }

        .page {
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
            background: #fdf8ee;
        }

        /* Outer thick border */
        .border-outer {
            position: absolute;
            top: 6mm; left: 6mm; right: 6mm; bottom: 6mm;
            border: 5px solid {{ $primary_color }};
        }
        /* Inner thin border */
        .border-inner {
            position: absolute;
            top: 10mm; left: 10mm; right: 10mm; bottom: 10mm;
            border: 1.5px solid {{ $primary_color }};
            opacity: .6;
        }
        /* Corner ornaments */
        .corner-ornament {
            position: absolute;
            width: 18mm; height: 18mm;
            font-size: 22pt;
            color: {{ $primary_color }};
            line-height: 1;
            text-align: center;
        }
        .co-tl { top: 3mm; left: 3mm; }
        .co-tr { top: 3mm; right: 3mm; text-align: right; }
        .co-bl { bottom: 3mm; left: 3mm; }
        .co-br { bottom: 3mm; right: 3mm; text-align: right; }

        /* Header */
        .header-area {
            position: absolute;
            top: 16mm;
            left: 28mm;
            right: 28mm;
            text-align: center;
        }
        .logo-img { max-height: 14mm; max-width: 38mm; margin-bottom: 2mm; }
        .org-name {
            font-size: 9.5pt;
            color: {{ $primary_color }};
            letter-spacing: 5px;
            text-transform: uppercase;
            font-family: DejaVu Sans, sans-serif;
            font-weight: bold;
        }
        .header-rule {
            width: 80mm;
            border: none;
            border-top: 1.5px solid {{ $primary_color }};
            margin: 3mm auto;
        }

        /* Certificate title */
        .cert-title-area {
            position: absolute;
            top: 38mm;
            left: 28mm;
            right: 28mm;
            text-align: center;
        }
        .cert-title {
            font-size: 28pt;
            font-weight: bold;
            color: {{ $primary_color }};
            letter-spacing: 3px;
        }
        .cert-subtitle {
            font-size: 13pt;
            color: {{ $secondary_color }};
            letter-spacing: 8px;
            text-transform: uppercase;
            font-family: DejaVu Sans, sans-serif;
            margin-top: 1mm;
        }

        /* Body content */
        .body-area {
            position: absolute;
            top: 72mm;
            left: 30mm;
            right: 30mm;
            text-align: center;
        }
        .presented-to {
            font-size: 9.5pt;
            color: #5a3a00;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-family: DejaVu Sans, sans-serif;
            margin-bottom: 2mm;
        }
        .student-name {
            font-size: 30pt;
            font-weight: bold;
            color: #1a1208;
            font-family: DejaVu Serif, serif;
            line-height: 1.15;
            margin-bottom: 3mm;
        }
        .body-rule {
            width: 65mm;
            border: none;
            border-top: 2px solid {{ $primary_color }};
            margin: 0 auto 3mm auto;
        }
        .course-label {
            font-size: 9pt;
            color: #5a3a00;
            font-family: DejaVu Sans, sans-serif;
            margin-bottom: 1.5mm;
        }
        .course-name {
            font-size: 14pt;
            font-weight: bold;
            color: #1a1208;
            margin-bottom: 2mm;
        }
        .score-line {
            font-size: 9pt;
            color: #5a3a00;
            font-family: DejaVu Sans, sans-serif;
        }
        .score-val { font-weight: bold; color: #1a6b3c; font-size: 11pt; }

        /* Footer */
        .footer-area {
            position: absolute;
            bottom: 18mm;
            left: 28mm;
            right: 28mm;
        }
        .footer-meta {
            text-align: center;
            margin-bottom: 4mm;
            font-family: DejaVu Sans, sans-serif;
            font-size: 7.5pt;
            color: #7a5a20;
        }
        .footer-meta .sep { margin: 0 4mm; color: {{ $primary_color }}; }

        /* Signature blocks */
        .sig-tbl { width: 68%; margin: 0 auto; border-collapse: collapse; }
        .sig-tbl td { width: 50%; text-align: center; padding: 0 8mm; vertical-align: bottom; }
        .sig-img   { height: 18mm; max-width: 52mm; object-fit: contain; display: block; margin: 0 auto 1mm auto; }
        .sig-space { height: 18mm; }
        .sig-line  { border-bottom: 1.5px solid {{ $primary_color }}; width: 45mm; margin: 0 auto 1.5mm auto; }
        .sig-name  { font-size: 8pt; font-weight: bold; color: #1a1208; font-family: DejaVu Sans, sans-serif; }
        .sig-title { font-size: 7pt; color: #7a5a20; font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
<div class="page">
    <div class="border-outer"></div>
    <div class="border-inner"></div>

    {{-- Corner ornaments --}}
    <div class="corner-ornament co-tl">&#10022;</div>
    <div class="corner-ornament co-tr">&#10022;</div>
    <div class="corner-ornament co-bl">&#10022;</div>
    <div class="corner-ornament co-br">&#10022;</div>

    {{-- Header --}}
    <div class="header-area">
        @if (!empty($logo_data_uri))
            <img src="{{ $logo_data_uri }}" alt="" class="logo-img">
        @endif
        <div class="org-name">{{ $organization_name }}</div>
        <hr class="header-rule">
    </div>

    {{-- Title --}}
    <div class="cert-title-area">
        <div class="cert-title">Certificate</div>
        <div class="cert-subtitle">of Completion</div>
    </div>

    {{-- Body --}}
    <div class="body-area">
        <div class="presented-to">{{ __('This is to certify that') }}</div>
        <div class="student-name">{{ $student_name }}</div>
        <hr class="body-rule">
        <div class="course-label">{{ __('has successfully completed the course') }}</div>
        <div class="course-name">{{ $course_name }}</div>
        <div class="score-line">
            {{ __('with a final score of') }}
            <span class="score-val">{{ number_format($total_score, 1) }}</span>
            {{ __('out of 100') }}
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer-area">
        <div class="footer-meta">
            {{ __('Tanggal Diterbitkan') }}: <strong>{{ $issued_date }}</strong>
            <span class="sep">|</span>
            {{ __('Kode Verifikasi') }}: <strong>{{ $certificate_code }}</strong>
        </div>
        <table class="sig-tbl">
            <tr>
                <td>
                    @if (!empty($instructor_signature_url))
                        <img src="{{ $instructor_signature_url }}" alt="" class="sig-img">
                    @else
                        <div class="sig-space"></div>
                    @endif
                    <div class="sig-line"></div>
                    <div class="sig-name">{{ $instructor_name ?? __('Instruktur') }}</div>
                    <div class="sig-title">{{ __('Instruktur') }}</div>
                </td>
                <td>
                    @if (!empty($kepala_signature_url))
                        <img src="{{ $kepala_signature_url }}" alt="" class="sig-img">
                    @else
                        <div class="sig-space"></div>
                    @endif
                    <div class="sig-line"></div>
                    <div class="sig-name">{{ $kepala_name ?? __('Kepala Training') }}</div>
                    <div class="sig-title">{{ $kepala_title ?? $organization_name }}</div>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
