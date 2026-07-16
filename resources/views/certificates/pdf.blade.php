<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat Kelulusan</title>
    <style>
        @page { margin: 20px; }
        body { 
            font-family: sans-serif; 
            margin: 0; 
            padding: 0; 
            background: #ffffff;
            color: #334155; 
        }
        .container {
            border: 8px double #fcd34d;
            height: 94%;
        }
        .banner {
            height: 12px;
            background: #fbbf24;
        }
        .content {
            padding: 40px 60px;
            text-align: center;
        }
        .icon {
            font-size: 50px;
            margin-bottom: 10px;
            color: #f59e0b;
        }
        .label {
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 4px;
            color: #d97706;
            text-transform: uppercase;
        }
        .sub-label {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 5px;
        }
        .name {
            font-size: 42px;
            font-weight: bold;
            color: #1e293b;
            margin: 20px 0;
            font-family: serif;
        }
        .divider {
            width: 100px;
            height: 2px;
            background: #fcd34d;
            margin: 0 auto;
        }
        .desc {
            font-size: 16px;
            color: #475569;
            margin-top: 30px;
        }
        .course {
            font-size: 26px;
            font-weight: bold;
            color: #1e293b;
            margin: 10px 0;
        }
        .score {
            font-size: 16px;
            color: #64748b;
        }
        .score-val {
            font-weight: bold;
            color: #059669;
        }
        .meta-table {
            width: 60%;
            margin: 30px auto 0 auto;
        }
        .meta-table td {
            width: 50%;
            text-align: center;
        }
        .meta-label {
            font-size: 12px;
            color: #94a3b8;
            margin: 0 0 5px 0;
        }
        .meta-val {
            font-size: 16px;
            font-weight: bold;
            color: #334155;
        }
        .code {
            font-family: monospace;
            letter-spacing: 2px;
        }
        .signature-table {
            width: 80%;
            margin: 70px auto 0 auto;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
        }
        .sign-line {
            border-bottom: 2px solid #cbd5e1;
            width: 150px;
            margin: 0 auto 5px auto;
        }
        .sign-label {
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="banner"></div>
        
        <div class="content">
            <div class="icon">🏆</div>
            
            <div class="label">Sertifikat Kelulusan</div>
            <div class="sub-label">Diberikan kepada:</div>
            
            <div class="name">{{ $certificate->user->name }}</div>
            <div class="divider"></div>
            
            <div class="desc">Telah berhasil menyelesaikan dan lulus semua evaluasi dalam course:</div>
            <div class="course">{{ $certificate->course->title }}</div>
            
            <div class="score">dengan nilai rata-rata <span class="score-val">{{ number_format($certificate->total_score, 1) }}</span> dari 100</div>
            
            <table class="meta-table">
                <tr>
                    <td>
                        <p class="meta-label">Tanggal Diterbitkan</p>
                        <div class="meta-val">{{ $certificate->issued_at->format('d F Y') }}</div>
                    </td>
                    <td>
                        <p class="meta-label">Kode Verifikasi</p>
                        <div class="meta-val code">{{ $certificate->certificate_code }}</div>
                    </td>
                </tr>
            </table>
            
            <table class="signature-table">
                <tr>
                    <td>
                        <div class="sign-line"></div>
                        <div class="sign-label">Instruktur</div>
                    </td>
                    <td>
                        <div class="sign-line"></div>
                        <div class="sign-label">Garbarata Training Center</div>
                    </td>
                </tr>
            </table>
        </div>
        
    </div>
</body>
</html>
