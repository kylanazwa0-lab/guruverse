<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificate</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: 'Arial', sans-serif;
            background: white;
        }
        .certificate {
            border: 3px solid #d4af37;
            padding: 40px;
            text-align: center;
            background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
            min-height: 600px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            margin-bottom: 30px;
        }
        .logo {
            width: 100px;
            margin-bottom: 15px;
        }
        .title {
            font-size: 42px;
            font-weight: bold;
            color: #d4af37;
            margin: 20px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .subtitle {
            font-size: 20px;
            color: #666;
            margin-bottom: 40px;
            font-style: italic;
        }
        .content {
            margin: 40px 0;
        }
        .intro-text {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }
        .student-name {
            font-size: 36px;
            font-weight: bold;
            color: #1a1a1a;
            margin: 30px 0;
            text-decoration: underline;
            text-decoration-color: #d4af37;
            text-decoration-thickness: 2px;
        }
        .achievement-text {
            font-size: 16px;
            color: #333;
            margin: 20px 0;
            line-height: 1.6;
        }
        .course-name {
            font-size: 24px;
            font-weight: bold;
            color: #d4af37;
            margin: 20px 0;
        }
        .date-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
        }
        .signature-line {
            width: 200px;
            border-top: 2px solid #000;
            margin-top: 50px;
            text-align: center;
        }
        .signature-label {
            font-size: 12px;
            margin-top: 5px;
            color: #666;
        }
        .date-label {
            font-size: 14px;
            color: #666;
        }
        .completion-date {
            font-size: 16px;
            font-weight: bold;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <div class="title">Sertifikat Penghargaan</div>
            <div class="subtitle">Certificate of Completion</div>
        </div>

        <div class="content">
            <div class="intro-text">Dengan bangga kami menganugerahi</div>

            <div class="student-name">{{ $studentName }}</div>

            <div class="achievement-text">
                Sebagai bukti telah menyelesaikan program pembelajaran
            </div>

            <div class="course-name">{{ $courseName }}</div>

            <div class="achievement-text">
                Dengan memuaskan dan menunjukkan dedikasi serta komitmen dalam menuntut ilmu.<br>
                Semoga sertifikat ini menjadi motivasi untuk terus belajar dan berkembang.
            </div>
        </div>

        <div class="date-section">
            <div>
                <div class="signature-line"></div>
                <div class="signature-label">Direktur LMS</div>
            </div>
            <div>
                <div class="date-label">Tanggal:</div>
                <div class="completion-date">{{ $completionDate }}</div>
            </div>
        </div>
    </div>
</body>
</html>
