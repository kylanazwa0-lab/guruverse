<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Penyelesaian</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Georgia', serif;
            background-color: #f5f5f5;
        }
        
        .certificate {
            width: 100%;
            height: 11in;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            page-break-after: always;
        }
        
        .certificate-content {
            width: 95%;
            height: 95%;
            background: white;
            border: 20px solid #d4af37;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        .certificate-content::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 15px;
            width: 50px;
            height: 50px;
            border: 3px solid #d4af37;
            border-radius: 50%;
        }
        
        .certificate-content::after {
            content: '';
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 50px;
            height: 50px;
            border: 3px solid #d4af37;
            border-radius: 50%;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .header h1 {
            color: #667eea;
            font-size: 48px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .divider {
            width: 200px;
            height: 3px;
            background-color: #d4af37;
            margin: 20px 0;
        }
        
        .content {
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .subtitle {
            color: #666;
            font-size: 18px;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }
        
        .student-name {
            font-size: 36px;
            color: #764ba2;
            font-weight: bold;
            margin: 20px 0;
            text-decoration: underline;
        }
        
        .achievement-text {
            color: #333;
            font-size: 16px;
            line-height: 1.8;
            margin: 30px 0;
            max-width: 600px;
        }
        
        .course-name {
            color: #667eea;
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0;
        }
        
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }
        
        .certificate-number {
            color: #999;
            font-size: 12px;
        }
        
        .date {
            margin-top: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="certificate-content">
            <div class="header">
                <h1>🎓 Sertifikat</h1>
                <div class="divider"></div>
                <p class="subtitle">Penghargaan atas Penyelesaian Pembelajaran</p>
            </div>
            
            <div class="content">
                <p style="color: #333; font-size: 16px;">Dengan bangga kami persembahkan kepada</p>
                
                <div class="student-name">{{ $student_name }}</div>
                
                <p class="achievement-text">
                    Telah berhasil menyelesaikan dan menguasai seluruh materi dalam kursus
                </p>
                
                <div class="course-name">{{ $course_name }}</div>
                
                <p class="achievement-text" style="margin-top: 10px;">
                    dengan hasil yang memuaskan. Semoga pengetahuan ini bermanfaat dan terus dikembangkan.
                </p>
            </div>
            
            <div class="footer">
                <div class="date">
                    Tanggal Penyelesaian: <strong>{{ $completion_date }}</strong>
                </div>
                <div class="certificate-number">
                    Nomor Sertifikat: {{ $certificate_number }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
