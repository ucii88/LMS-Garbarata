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

        /* Page: A4 landscape = 297mm × 210mm */
        .page {
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
            background: #fffdf5;
        }

        /* ——— Decorative layer ——— */
        .banner-top    { position:absolute; top:0;        left:0; right:0; height:8mm;   background:#d97706; }
        .banner-bottom { position:absolute; bottom:0;     left:0; right:0; height:8mm;   background:#d97706; }
        .stripe-top    { position:absolute; top:6.5mm;    left:0; right:0; height:1.5mm; background:#fbbf24; }
        .stripe-bottom { position:absolute; bottom:6.5mm; left:0; right:0; height:1.5mm; background:#fbbf24; }
        .outer-border  { position:absolute; top:11mm; left:10mm; right:10mm; bottom:11mm; border:2.5px solid #b45309; }
        .inner-border  { position:absolute; top:14mm; left:13mm; right:13mm; bottom:14mm; border:1px solid #fcd34d; }
        .corner        { position:absolute; width:14mm; height:14mm; }
        .corner-tl { top:8mm;    left:7mm;  border-top:3.5px solid #92400e; border-left:3.5px solid #92400e; }
        .corner-tr { top:8mm;    right:7mm; border-top:3.5px solid #92400e; border-right:3.5px solid #92400e; }
        .corner-bl { bottom:8mm; left:7mm;  border-bottom:3.5px solid #92400e; border-left:3.5px solid #92400e; }
        .corner-br { bottom:8mm; right:7mm; border-bottom:3.5px solid #92400e; border-right:3.5px solid #92400e; }

        /*
         * ——— Content area ———
         * Dari gambar target, "GARBARATA" mulai di ~18% dari atas halaman
         * 18% × 210mm = 37.8mm ≈ 38mm dari atas halaman
         * show.blade.php: content flex-centered dalam inner area (top:4.8%=10mm, bottom:4.8%=200mm)
         * Jadi content mulai di ~10mm (inner top) + (190mm - ~130mm content) / 2 ≈ 40mm
         */
        .content {
            position: absolute;
            top: 38mm;
            left: 36mm;   /* 5% border + 8% padding ≈ 36mm dari tepi */
            right: 36mm;
            text-align: center;
        }

        /* ——— Typography (dikalibrasi: 1vw dari show.blade.php = 8.42pt di PDF 297mm) ——— */
        /* org-name: 1.05vw = 8.84pt → 9pt */
        .org-name {
            font-size: 9pt;
            color: #b45309;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 1mm;
            font-weight: bold;
        }
        /* cert-title: 1.5vw = 12.6pt → 13pt */
        .cert-title {
            font-size: 13pt;
            font-weight: bold;
            letter-spacing: 5px;
            color: #92400e;
            text-transform: uppercase;
            margin-bottom: 2.5mm;
        }
        /* stars: 2vw = 16.8pt → 17pt */
        .stars {
            font-size: 17pt;
            color: #d97706;
            letter-spacing: 5px;
            margin-bottom: 2.5mm;
        }
        /* rec-label: 0.9vw = 7.6pt → 8pt */
        .rec-label {
            font-size: 8pt;
            color: #64748b;
            margin-bottom: 1.5mm;
        }
        /* rec-name: 3.5vw = 29.5pt → 30pt */
        .rec-name {
            font-size: 30pt;
            font-weight: bold;
            color: #1e293b;
            font-family: DejaVu Serif, serif;
            line-height: 1.1;
            margin-bottom: 1.5mm;
        }
        /* divider: 20% of content width ≈ 45mm */
        .divider {
            width: 45mm;
            height: 2px;
            background: #d97706;
            margin: 0 auto 2.5mm auto;
        }
        /* comp-text: 0.9vw → 8pt */
        .comp-text {
            font-size: 8pt;
            color: #475569;
            margin-bottom: 1mm;
        }
        /* course-nm: 1.5vw → 13pt */
        .course-nm {
            font-size: 13pt;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 1mm;
        }
        /* score: 0.9vw → 8pt, score-val: 1.1vw → 9pt */
        .score-text {
            font-size: 8pt;
            color: #475569;
            margin-bottom: 4mm;
        }
        .score-val {
            font-weight: bold;
            color: #059669;
            font-size: 9pt;
        }

        /* Meta table: 55% of content width */
        .meta-tbl { width: 55%; margin: 0 auto 4mm auto; border-collapse: collapse; }
        .meta-tbl td { width: 50%; text-align: center; padding: 0 4mm; }
        .meta-tbl td:first-child { border-right: 1px solid #e2e8f0; }
        /* meta-lbl: 0.7vw → 6pt */
        .meta-lbl { font-size: 6pt; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1mm; }
        /* meta-val: 0.95vw → 8pt */
        .meta-val { font-size: 8pt; font-weight: bold; color: #334155; }
        .meta-code { font-family: DejaVu Sans Mono, monospace; font-size: 7.5pt; letter-spacing: 2px; }

        /* Signature table: 65% of content width */
        .sig-tbl { width: 65%; margin: 0 auto; border-collapse: collapse; }
        .sig-tbl td { width: 50%; text-align: center; padding: 0 10mm; }
        /* sig-space: 3vw = 25.3pt = ~9mm */
        .sig-space { height: 9mm; }
        .sig-line  { border-bottom: 1.5px solid #cbd5e1; width: 35mm; margin: 0 auto 1.5mm auto; }
        /* sig-lbl: 0.75vw → 6.3pt → 6.5pt */
        .sig-lbl   { font-size: 6.5pt; color: #64748b; }
    </style>
</head>
<body>
<div class="page">

    {{-- Dekorasi --}}
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

    {{-- Konten --}}
    <div class="content">
        <div class="org-name">Garbarata Training Center</div>
        <div class="cert-title">Sertifikat Kelulusan</div>
        <div class="stars">&#9733; &#9733; &#9733;</div>
        <div class="rec-label">Diberikan kepada:</div>
        <div class="rec-name">{{ $certificate->user->name }}</div>
        <div class="divider"></div>
        <div class="comp-text">Telah berhasil menyelesaikan dan lulus semua evaluasi dalam kursus:</div>
        <div class="course-nm">{{ $certificate->course->title }}</div>
        <div class="score-text">
            dengan nilai rata-rata
            <span class="score-val">{{ number_format($certificate->total_score, 1) }}</span>
            dari 100
        </div>

        <table class="meta-tbl">
            <tr>
                <td>
                    <div class="meta-lbl">Tanggal Diterbitkan</div>
                    <div class="meta-val">{{ $certificate->issued_at->locale('id')->translatedFormat('d F Y') }}</div>
                </td>
                <td>
                    <div class="meta-lbl">Kode Verifikasi</div>
                    <div class="meta-val meta-code">{{ $certificate->certificate_code }}</div>
                </td>
            </tr>
        </table>

        <table class="sig-tbl">
            <tr>
                <td>
                    <div class="sig-space"></div>
                    <div class="sig-line"></div>
                    <div class="sig-lbl">Instruktur</div>
                </td>
                <td>
                    <div class="sig-space"></div>
                    <div class="sig-line"></div>
                    <div class="sig-lbl">Garbarata Training Center</div>
                </td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>
