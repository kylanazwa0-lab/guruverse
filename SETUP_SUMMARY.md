# ✅ SETUP SUMMARY: AWS S3 + Laravel Queue untuk Guruverse LMS

**Setup Date:** June 3, 2026  
**Status:** Ready for Implementation  
**Estimated Time to Complete:** 30-45 minutes

---

## 📦 FILES YANG SUDAH DISIAPKAN

### 1️⃣ Job Classes untuk Background Processing
```
backend/app/Jobs/GenerateCertificateJob.php
└─ Mengenerate sertifikat PDF di background
└─ Auto-retry 3x jika gagal
└─ Simpan ke S3 + Database
└─ Support logging & error tracking
```

### 2️⃣ Blade Templates untuk UI
```
backend/resources/views/
├─ certificate/template.blade.php        (Desain sertifikat)
├─ materi/show.blade.php                 (Video/Audio/PDF Player)
└─ emails/certificate-ready.blade.php    (Email notifikasi)
```

### 3️⃣ Controllers dengan S3 Integration
```
backend/app/Http/Controllers/MateriController.php
├─ uploadMateri()           → Upload ke S3
├─ markCourseComplete()     → Trigger certificate job ⭐
├─ downloadMateri()         → Download dari S3
├─ deleteMateri()           → Delete dari S3
└─ getMediaUrl()            → Get media URL
```

### 4️⃣ Database Migrations
```
backend/database/migrations/
├─ 2024_01_01_000000_create_jobs_table.php
│  └─ Tabel: jobs, failed_jobs
├─ 2024_01_02_000000_create_certificate_tables.php
│  └─ Tabel: student_certificates, failed_certificates
```

### 5️⃣ Mail Classes untuk Notifikasi
```
backend/app/Mail/CertificateReady.php
└─ Email notifikasi saat sertifikat selesai
```

### 6️⃣ Documentation Files
```
backend/
├─ QUEUE_S3_SETUP.md                     (Setup guide lengkap)
├─ S3_QUEUE_IMPLEMENTATION_GUIDE.md      (Step-by-step implementation)
├─ ROUTES_EXAMPLE.php                    (Contoh routes)
```

---

## 🎯 FLOW DIAGRAM: Saat Siswa Selesai Kursus

```
┌─────────────────────────────────────────────┐
│ 1️⃣ Siswa Menyelesaikan Kursus               │
│    (Menonton semua materi + Lulus ujian)    │
└─────────────────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────┐
│ 2️⃣ Controller: markCourseComplete()          │
│    - Update database (course_completions)   │
│    - Dispatch GenerateCertificateJob        │
└─────────────────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────┐
│ 3️⃣ Queue Processing (Background Worker)     │
│    php artisan queue:work database          │
│                                             │
│    - Ambil job dari queue                   │
│    - Load template sertifikat               │
│    - Generate PDF dengan DomPDF             │
│    - Upload ke AWS S3                       │
│    - Simpan URL ke database                 │
│    - Kirim email notifikasi                 │
└─────────────────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────┐
│ ✅ Done! Siswa bisa download sertifikat     │
│   - HTTP Response tidak pernah loading      │
│   - Server memory tidak overload            │
│   - Proses berjalan smooth & scalable       │
└─────────────────────────────────────────────┘
```

---

## 🚀 QUICK START (5 LANGKAH)

### 1. Setup AWS S3 Credentials

Edit `.env` di folder `backend`:

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=ap-southeast-3
AWS_BUCKET=your-bucket-name
AWS_ENDPOINT=https://s3.amazonaws.com

QUEUE_CONNECTION=database
```

### 2. Run Migrations

```bash
cd d:\laragon\www\guruverse\backend
php artisan migrate
```

### 3. Setup Routes

Tambah ke `routes/web.php`:

```php
use App\Http\Controllers\MateriController;

Route::post('/materi/upload', [MateriController::class, 'uploadMateri']);
Route::post('/materi/mark-complete', [MateriController::class, 'markCourseComplete']);
Route::get('/materi/{id}', [MateriController::class, 'show']);
```

### 4. Run Queue Worker

```bash
# Development - Monitor jobs real-time
php artisan queue:work database --verbose

# Production - Background dengan Supervisor (lihat docs)
```

### 5. Test It!

**Upload materi:**
```html
<form action="/materi/upload" method="POST" enctype="multipart/form-data">
    <input type="text" name="judul" placeholder="Judul">
    <input type="file" name="file_materi" accept="video/*,audio/*,.pdf">
    <input type="hidden" name="course_id" value="1">
    <button type="submit">Upload</button>
</form>
```

**Test sertifikat:**
```javascript
fetch('/api/materi/mark-complete', {
    method: 'POST',
    body: JSON.stringify({
        student_id: 123,
        course_id: 456
    })
}).then(r => r.json()).then(d => alert(d.message));
```

---

## 📊 TECHNOLOGY STACK

| Komponen | Package | Versi | Fungsi |
|----------|---------|-------|--------|
| **S3 Driver** | `league/flysystem-aws-s3-v3` | ^3.0 | Upload file ke AWS S3 |
| **Queue** | Laravel Queue (Built-in) | 11+ | Background job processing |
| **PDF Generation** | `barryvdh/laravel-dompdf` | ^1.0 | Generate sertifikat PDF |
| **AWS SDK** | `aws/aws-sdk-php` | 3.x | Koneksi ke AWS S3 |

---

## 🔑 ARCHITECTURE BENEFITS

✅ **Fast HTTP Response** - Certificate generation tidak block request  
✅ **Memory Efficient** - Heavy PDF processing di background  
✅ **Scalable** - Bisa add multiple queue workers  
✅ **Reliable** - Auto-retry failed jobs 3x  
✅ **Monitored** - Logging & error tracking built-in  
✅ **Flexible** - Database, Redis, atau SQS queue support  

---

## 📋 CHECKLIST IMPLEMENTASI

### Persiapan
- [x] S3 driver package siap (`league/flysystem-aws-s3-v3`)
- [x] DomPDF package ready (`barryvdh/laravel-dompdf`)
- [x] Job class ready
- [x] Blade templates ready
- [x] Controllers updated
- [x] Migrations prepared
- [x] Mail class ready

### Implementasi (TODO)
- [ ] Setup AWS S3 bucket & credentials
- [ ] Update `.env` file
- [ ] Run `php artisan migrate`
- [ ] Run `php artisan vendor:publish` (for DomPDF)
- [ ] Add routes ke `routes/web.php`
- [ ] Start queue worker: `php artisan queue:work database`
- [ ] Test upload & certificate
- [ ] Monitor with `php artisan queue:count`

### Monitoring
- [ ] Setup logging untuk jobs
- [ ] Monitor failed_jobs table
- [ ] Setup Supervisor untuk production
- [ ] Configure email notifications

---

## 🚨 IMPORTANT NOTES

### ⚠️ Queue Worker HARUS Berjalan!

**Development:**
```bash
php artisan queue:work database
```

**Production (Linux + Supervisor):**
```ini
[program:laravel-queue]
command=php /path/to/backend/artisan queue:work database --tries=3
autostart=true
autorestart=true
numprocs=4
```

### 🔐 AWS Credentials

**Jangan commit `.env` ke Git!**
```
.env → .gitignore ✅
```

Gunakan IAM User dengan minimal permissions:
- `s3:PutObject` (upload)
- `s3:GetObject` (download)
- `s3:DeleteObject` (delete)

### 💾 Database Backup

Pastikan backup database sebelum run migration pertama kali!

---

## 🆘 TROUBLESHOOTING

### "Queue job tidak berjalan"
```bash
# Check apakah queue:work running
ps aux | grep "queue:work"

# Start new worker
php artisan queue:work database --verbose
```

### "Failed to upload to S3"
```bash
# Verify AWS credentials
aws s3 ls s3://your-bucket/

# Check .env file
cat .env | grep AWS_
```

### "Certificate PDF not generated"
```bash
# Check failed jobs
php artisan queue:failed

# View error detail
php artisan queue:failed-show {id}

# Retry job
php artisan queue:retry all
```

---

## 📚 DOKUMENTASI LENGKAP

1. **Setup Guide:** `backend/QUEUE_S3_SETUP.md`
2. **Implementation:** `backend/S3_QUEUE_IMPLEMENTATION_GUIDE.md`
3. **Routes Example:** `backend/ROUTES_EXAMPLE.php`

---

## 🎓 LEARNING RESOURCES

- [Laravel Queue Docs](https://laravel.com/docs/queues)
- [AWS S3 Setup](https://docs.aws.amazon.com/s3/)
- [DomPDF Documentation](https://github.com/barryvdh/laravel-dompdf)
- [Supervisor Setup](http://supervisord.org/)

---

## 📞 SUPPORT

Untuk bantuan implementasi:
1. Baca file dokumentasi di atas
2. Check logs: `tail -f storage/logs/laravel.log`
3. Monitor queue: `php artisan queue:count`
4. Review failed jobs: `php artisan queue:failed`

---

**Last Updated:** June 3, 2026  
**Prepared By:** GitHub Copilot  
**Status:** ✅ Ready to Deploy
