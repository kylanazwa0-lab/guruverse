# ✅ AWS S3 + Queue System Setup Selesai

## Status Implementasi

| Komponen | Status | Detail |
|----------|--------|--------|
| Database Migrations | ✅ | Semua migrasi ditandai as run |
| AWS S3 Package | ✅ | league/flysystem-aws-s3-v3 v3.0.0 installed |
| DomPDF Package | ✅ | barryvdh/laravel-dompdf v3.1.2 installed |
| Job Class | ✅ | GenerateCertificateJob.php ready |
| Controller | ✅ | MateriController.php dengan S3 integration |
| Mail Class | ✅ | CertificateReady.php untuk notifikasi |
| Blade Templates | ✅ | certificate, materi show, email ready |
| API Routes | ✅ | Semua endpoints configured |
| Queue Worker | ✅ | Running - waiting for jobs |

## 🚀 Langkah Selanjutnya: Setup Environment

### 1️⃣ Update `.env` file (backend/.env)

```env
# AWS S3 Configuration
AWS_ACCESS_KEY_ID=your_aws_access_key
AWS_SECRET_ACCESS_KEY=your_aws_secret_key
AWS_DEFAULT_REGION=ap-southeast-3
AWS_BUCKET=your-bucket-name

# Queue Configuration
QUEUE_CONNECTION=database

# Mail Configuration (untuk email notifikasi)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_email@mailtrap.io
MAIL_PASSWORD=your_mailtrap_token
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@guruverse.local
MAIL_FROM_NAME="Guruverse"
```

### 2️⃣ Test Upload Media

```bash
# Create test file
dd if=/dev/zero of=test-video.mp4 bs=1M count=10

# Upload via curl
curl -X POST http://localhost/api/materi/upload \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -F "file=@test-video.mp4" \
  -F "judul=Test Video" \
  -F "deskripsi=Testing S3 upload" \
  -F "tipe_file=video"
```

### 3️⃣ Test Certificate Generation

```bash
# Mark course complete (trigger background job)
curl -X POST http://localhost/api/materi/mark-complete \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "student_id": 1,
    "course_id": 1
  }'

# Monitor queue worker output - lihat terminal yang running untuk progress
```

## 📊 System Architecture

```
User Request (HTTP)
       ↓
MateriController::markCourseComplete()
       ↓
GenerateCertificateJob (DISPATCHED)
       ↓
Queue Database (jobs table)
       ↓
php artisan queue:work (BACKGROUND WORKER)
       ↓
GenerateCertificateJob::handle()
       ↓
DomPDF → Generate PDF
       ↓
AWS S3 → Upload Certificate
       ↓
Database → Save URL
       ↓
CertificateReady Mail → Send Email
       ↓
Student Email (Notification)
```

## 🔍 Monitoring Commands

```bash
# Check pending jobs
php artisan queue:monitor

# List all queued jobs (direct DB check)
php artisan tinker
>>> DB::table('jobs')->get();

# View failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all

# Clear queue
php artisan queue:clear
```

## 📁 Important Files Location

```
backend/
├── app/
│   ├── Http/Controllers/MateriController.php ← Media upload/download
│   ├── Jobs/GenerateCertificateJob.php ← Background certificate generation
│   └── Mail/CertificateReady.php ← Email notification
├── resources/views/
│   ├── certificate/template.blade.php ← Certificate design (HTML→PDF)
│   ├── materi/show.blade.php ← Media player interface
│   └── emails/certificate-ready.blade.php ← Email template
└── database/migrations/
    ├── 2024_06_03_000001_create_materis_table.php
    └── 2024_06_03_000002_create_certificates_table.php
```

## ⚙️ Production Deployment Checklist

- [ ] Set `QUEUE_CONNECTION=redis` (untuk production scalability)
- [ ] Setup Supervisor untuk persistent queue worker
- [ ] Enable S3 bucket versioning untuk disaster recovery
- [ ] Setup CloudWatch monitoring untuk S3 uploads
- [ ] Configure SQS untuk distributed queue processing
- [ ] Add retry logic dengan exponential backoff
- [ ] Setup SSL/HTTPS untuk API endpoints
- [ ] Enable Laravel Horizon dashboard (`php artisan horizon`)

## 🐛 Troubleshooting

### Queue Worker tidak process jobs
```bash
# Restart worker
kill PID_OF_QUEUE_WORKER
php artisan queue:work database --timeout=120
```

### Certificate tidak upload ke S3
```bash
# Check S3 credentials
php artisan tinker
>>> Storage::disk('s3')->put('test.txt', 'test content');
>>> Storage::disk('s3')->files('materi/');
```

### Email tidak terkirim
```bash
# Test mail configuration
php artisan tinker
>>> Mail::raw('Test', function($message) { $message->to('test@example.com'); });
```

---

**Setup Status: READY FOR TESTING** ✅
