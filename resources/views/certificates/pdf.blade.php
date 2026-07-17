<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat Kelulusan</title>
    <style>
        @page { margin: 0; size: A4 landscape; }
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0; padding: 0;
            background: #fffdf5;
            color: #1e293b;
        }
        .page {
            width: 297mm; height: 210mm;
            position: relative; overflow: hidden;
            background: #fffdf5;
        }
        .banner-top    { position:absolute; top:0; left:0; right:0; height:8mm; background:#d97706; }
        .banner-bottom { position:absolute; bottom:0; left:0; right:0; height:8mm; background:#d97706; }
        .stripe-top    { position:absolute; top:6.5mm; left:0; right:0; height:1.5mm; background:#fbbf24; }
        .stripe-bottom { position:absolute; bottom:6.5mm; left:0; right:0; height:1.5mm; background:#fbbf24; }
        .outer-border  { position:absolute; top:11mm; left:10mm; right:10mm; bottom:11mm; border:2.5px solid #b45309; }
        .inner-border  { position:absolute; top:14mm; left:13mm; right:13mm; bottom:14mm; border:1px solid #fcd34d; }
        .corner { position:absolute; width:14mm; height:14mm; }
        .corner-tl { top:8mm; left:7mm; border-top:3.5px solid #92400e; border-left:3.5px solid #92400e; }
        .corner-tr { top:8mm; right:7mm; border-top:3.5px solid #92400e; border-right:3.5px solid #92400e; }
        .corner-bl { bottom:8mm; left:7mm; border-bottom:3.5px solid #92400e; border-left:3.5px solid #92400e; }
        .corner-br { bottom:8mm; right:7mm; border-bottom:3.5px solid #92400e; border-right:3.5px solid #92400e; }
        .content {
            position:absolute; top:10mm; left:10mm; right:10mm; bottom:10mm;
            text-align:center; padding:6mm 22mm 4mm 22mm;
        }
        .org-name   { font-size:7.5pt; color:#b45309; letter-spacing:4px; text-transform:uppercase; margin-bottom:1mm; }
        .cert-title { font-size:11pt; font-weight:bold; letter-spacing:5px; color:#92400e; text-transform:uppercase; margin-bottom:3mm; }
        .stars      { font-size:14pt; color:#d97706; margin-bottom:2.5mm; letter-spacing:5px; }
        .rec-label  { font-size:9pt; color:#64748b; margin-bottom:1.5mm; }
        .rec-name   { font-size:28pt; font-weight:bold; color:#1e293b; font-family:DejaVu Serif,serif; margin:0 0 2.5mm 0; line-height:1.1; }
        .divider    { width:75mm; height:1.5px; background:#d97706; margin:0 auto 4mm auto; }
        .comp-text  { font-size:9pt; color:#475569; margin-bottom:1.5mm; }
        .course-nm  { font-size:14pt; font-weight:bold; color:#1e293b; margin-bottom:1.5mm; }
        .score-text { font-size:9pt; color:#475569; margin-bottom:5mm; }
        .score-val  { font-weight:bold; color:#059669; font-size:11pt; }
        .meta-tbl   { width:55%; margin:0 auto 6mm auto; border-collapse:collapse; }
        .meta-tbl td { width:50%; text-align:center; padding:0 5mm; }
        .meta-tbl td:first-child { border-right:1px solid #e2e8f0; }
        .meta-lbl   { font-size:7pt; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:1mm; }
        .meta-val   { font-size:9.5pt; font-weight:bold; color:#334155; }
        .meta-code  { font-family:DejaVu Sans Mono,monospace; font-size:8.5pt; letter-spacing:2px; }
        .sig-tbl    { width:65%; margin:0 auto; border-collapse:collapse; }
        .sig-tbl td { width:50%; text-align:center; padding:0 12mm; }
        .sig-space  { height:7mm; }
        .sig-line   { border-bottom:1.5px solid #cbd5e1; width:38mm; margin:0 auto 1.5mm auto; }
        .sig-lbl    { font-size:7.5pt; color:#64748b; }
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
    <div class="content">
        <div class="org-name">Garbarata Training Center</div>
        <div class="cert-title">Sertifikat Kelulusan</div>
        <div class="stars">&#9733; &#9733; &#9733;</div>
        <div class="rec-label">Diberikan kepada:</div>
        <div class="rec-name">{{ $certificate->user->name }}</div>
        <div class="divider"></div>
        <div class="comp-text">Telah berhasil menyelesaikan dan lulus semua evaluasi dalam kursus:</div>
        <div class="course-nm">{{ $certificate->course->title }}</div>
        <div class="score-text">dengan nilai rata-rata <span class="score-val">{{ number_format($certificate->total_score, 1) }}</span> dari 100</div>
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
