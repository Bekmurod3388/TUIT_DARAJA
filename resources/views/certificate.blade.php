<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>
    <style>
        body { font-family: 'DejaVu Sans', 'Arial', sans-serif; background: #f3f4f6; }
        .cert-bg {
            background: linear-gradient(135deg, #fef3c7 0%, #f3f4f6 100%);
            min-height: 100vh;
            padding: 40px 0;
        }
        .cert-box {
            border: 5px solid #2563eb;
            border-radius: 32px;
            padding: 48px 40px 40px 40px;
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            box-shadow: 0 8px 32px rgba(37,99,235,0.08);
            position: relative;
        }
        .cert-title {
            font-size: 2.8em;
            color: #2563eb;
            font-weight: bold;
            text-align: center;
            margin-bottom: 32px;
            letter-spacing: 2px;
        }
        .cert-icon {
            text-align: center;
            font-size: 3.5em;
            margin-bottom: 12px;
        }
        .cert-info {
            font-size: 1.2em;
            margin-bottom: 20px;
            color: #222;
        }
        .cert-label {
            font-weight: bold;
            color: #2563eb;
            letter-spacing: 1px;
        }
        .cert-footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .cert-sign {
            font-size: 1.1em;
            color: #444;
            text-align: right;
        }
        .cert-qr {
            border: 2px solid #2563eb;
            border-radius: 12px;
            padding: 8px;
            background: #f3f4f6;
            box-shadow: 0 2px 8px rgba(37,99,235,0.08);
        }
        .cert-date {
            text-align: right;
            color: #888;
            font-size: 1em;
            margin-top: 16px;
        }
    </style>
</head>
<body class="cert-bg">
    <div class="cert-box">
        <div class="cert-icon">🎓</div>
        <div class="cert-title">SERTIFIKAT</div>
        <div class="cert-info"><span class="cert-label">F.I.O:</span> {{ $application->last_name }} {{ $application->first_name }} {{ $application->middle_name }}</div>
        <div class="cert-info"><span class="cert-label">Dastur:</span> {{ $application->specalization->name ?? '-' }} ({{ $application->specalization->code ?? '' }})</div>
        <div class="cert-info"><span class="cert-label">Fan:</span> {{ $application->subject }}</div>
        <div class="cert-info"><span class="cert-label">Ball:</span> {{ $application->score }}</div>
        <div class="cert-date"><span class="cert-label">Sana:</span> {{ $application->updated_at->format('Y-m-d') }}</div>
        <div class="cert-footer">
            <div class="cert-qr">
                {!! $qrSvg !!}
            </div>
            <div class="cert-sign">
                <div style="margin-bottom: 18px;">__________________________</div>
                <div style="font-size:0.95em; color:#888;">Komissiya raisi (imzo)</div>
            </div>
        </div>
    </div>
</body>
</html> 