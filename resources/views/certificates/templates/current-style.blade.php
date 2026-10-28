<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat Kelulusan</title>
    <style>
        @page { margin: 0; size: A4 landscape; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #fffdf5;
            color: #1e293b;
        }

        .page {
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
            background: #fffdf5;
        }

        /* Decorative layer — uses $primary_color / $secondary_color */
        .banner-top    { position:absolute; top:0;        left:0; right:0; height:8mm;   background:{{ $primary_color }}; }
        .banner-bottom { position:absolute; bottom:0;     left:0; right:0; height:8mm;   background:{{ $primary_color }}; }
        .stripe-top    { position:absolute; top:6.5mm;    left:0; right:0; height:1.5mm; background:{{ $secondary_color }}; opacity:.7; }
        .stripe-bottom { position:absolute; bottom:6.5mm; left:0; right:0; height:1.5mm; background:{{ $secondary_color }}; opacity:.7; }
        .outer-border  { position:absolute; top:11mm; left:10mm; right:10mm; bottom:11mm; border:2.5px solid {{ $secondary_color }}; }
        .inner-border  { position:absolute; top:14mm; left:13mm; right:13mm; bottom:14mm; border:1px solid {{ $secondary_color }}; opacity:.5; }
        .corner        { position:absolute; width:14mm; height:14mm; }
        .corner-tl { top:8mm;    left:7mm;  border-top:3.5px solid {{ $secondary_color }}; border-left:3.5px solid {{ $secondary_color }}; }
        .corner-tr { top:8mm;    right:7mm; border-top:3.5px solid {{ $secondary_color }}; border-right:3.5px solid {{ $secondary_color }}; }
        .corner-bl { bottom:8mm; left:7mm;  border-bottom:3.5px solid {{ $secondary_color }}; border-left:3.5px solid {{ $secondary_color }}; }
        .corner-br { bottom:8mm; right:7mm; border-bottom:3.5px solid {{ $secondary_color }}; border-right:3.5px solid {{ $secondary_color }}; }

        .header-area {
            position: absolute;
            top: 18mm;
            left: 28mm;
            right: 28mm;
            text-align: center;
        }
        .logo-img {
            max-height: 16mm;
            max-width: 40mm;
            margin-bottom: 2mm;
        }
        .org-name {
            font-size: 10.5pt;
            color: {{ $secondary_color }};
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 2mm;
            font-weight: bold;
        }
        .cert-title {
            font-size: 15pt;
            font-weight: bold;
            letter-spacing: 5px;
            color: {{ $secondary_color }};
            text-transform: uppercase;
        }

        .middle-container {
            position: absolute;
            top: 54mm;
            left: 28mm;
            right: 28mm;
            height: 84mm;
        }
        .middle-table { width:100%; height:100%; border-collapse:collapse; }
        .middle-cell  { vertical-align:middle; text-align:center; }

        .footer-area {
            position: absolute;
            bottom: 20mm;
            left: 28mm;
            right: 28mm;
            text-align: center;
        }

        .stars    { font-size: 20pt; color: {{ $primary_color }}; letter-spacing: 5px; margin-bottom: 0; }
        .rec-label { font-size: 9pt; color: #64748b; margin-bottom: 2mm; }
        .rec-name  {
            font-size: 32pt;
            font-weight: bold;
            color: #1e293b;
            font-family: DejaVu Serif, serif;
            line-height: 1.1;
            margin-bottom: 3mm;
        }
        .divider   { width:60mm; height:2px; background:{{ $primary_color }}; margin:0 auto 3mm auto; }
        .comp-text { font-size: 9pt; color: #475569; margin-bottom: 2mm; }
        .course-nm { font-size: 14pt; font-weight: bold; color: #1e293b; margin-bottom: 2mm; }
        .score-text { font-size: 9pt; color: #475569; }
        .score-val  { font-weight: bold; color: #059669; font-size: 11pt; }

        .meta-tbl { width: 55%; margin: 0 auto 4mm auto; border-collapse: collapse; }
        .meta-tbl td { width: 50%; text-align: center; padding: 0 4mm; }
        .meta-tbl td:first-child { border-right: 1px solid #e2e8f0; }
        .meta-lbl { font-size: 7pt; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1mm; }
        .meta-val { font-size: 9.5pt; font-weight: bold; color: #334155; }
        .meta-code { font-family: DejaVu Sans Mono, monospace; font-size: 8.5pt; letter-spacing: 2px; }

        /* Signature table — 2 columns */
        .sig-tbl { width: 70%; margin: 0 auto; border-collapse: collapse; }
        .sig-tbl td { width: 50%; text-align: center; padding: 0 8mm; }
        .sig-space { height: 18mm; }
        .sig-img   { height: 18mm; max-width: 52mm; object-fit: contain; display: block; margin: 0 auto 1mm auto; }
        .sig-line  { border-bottom: 1.5px solid #cbd5e1; width: 42mm; margin: 0 auto 1.5mm auto; }
        .sig-name  { font-size: 8pt; font-weight: bold; color: #334155; }
        .sig-lbl   { font-size: 7.5pt; color: #64748b; }
    </style>
</head>
<body>
<div class="page">
    <div class="banner-top"></div>
    <div class="stripe-top"></div>
    <div class="banner-bottom"></div>
    <div class="stripe-bottom"></div>
    <div class="outer-border"></div>
    <div class="inner-border"></div>
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    <div class="header-area">
        @if (!empty($logo_data_uri))
            <img src="{{ $logo_data_uri }}" alt="" class="logo-img">
        @endif
        <div class="org-name">{{ $organization_name }}</div>
        <div class="cert-title">{{ __('Sertifikat Kelulusan') }}</div>
    </div>

    <div class="middle-container">
        <table class="middle-table">
            <tr>
                <td class="middle-cell">
                    <div class="stars">&#9733; &#9733; &#9733;</div>
                    <div class="rec-label">{{ __('Diberikan kepada:') }}</div>
                    <div class="rec-name">{{ $student_name }}</div>
                    <div class="divider"></div>
                    <div class="comp-text">{{ __('Telah berhasil menyelesaikan dan lulus semua evaluasi dalam kursus:') }}</div>
                    <div class="course-nm">{{ $course_name }}</div>
                    <div class="score-text">
                        {{ __('dengan nilai rata-rata') }}
                        <span class="score-val">{{ number_format($total_score, 1) }}</span>
                        {{ __('dari 100') }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer-area">
        <table class="meta-tbl">
            <tr>
                <td>
                    <div class="meta-lbl">{{ __('Tanggal Diterbitkan') }}</div>
                    <div class="meta-val">{{ $issued_date }}</div>
                </td>
                <td>
                    <div class="meta-lbl">{{ __('Kode Verifikasi') }}</div>
                    <div class="meta-val meta-code">{{ $certificate_code }}</div>
                </td>
            </tr>
        </table>

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
                    <div class="sig-lbl">{{ __('Instruktur') }}</div>
                </td>
                <td>
                    @if (!empty($kepala_signature_url))
                        <img src="{{ $kepala_signature_url }}" alt="" class="sig-img">
                    @else
                        <div class="sig-space"></div>
                    @endif
                    <div class="sig-line"></div>
                    <div class="sig-name">{{ $kepala_name ?? __('Kepala Training') }}</div>
                    <div class="sig-lbl">{{ $kepala_title ?? $organization_name }}</div>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
