# ⚡ QUICK START: AWS S3 + Queue dalam 5 Menit

**Tujuan:** Setup S3 storage & background certificate generation untuk Guruverse LMS

---

## 🚀 5 LANGKAH CEPAT

### 1️⃣ Publish DomPDF Config (1 menit)

```bash
cd d:\laragon\www\guruverse\backend
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

### 2️⃣ Update `.env` dengan AWS S3 (2 menit)

Edit file `d:\laragon\www\guruverse\backend\.env`:

```env
FILESYSTEM_DISK=s3

AWS_ACCESS_KEY_ID=AKIAIOSFODNN7EXAMPLE
AWS_SECRET_ACCESS_KEY=wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY
AWS_DEFAULT_REGION=ap-southeast-3
AWS_BUCKET=guruverse-lms
AWS_ENDPOINT=https://s3.amazonaws.com

QUEUE_CONNECTION=database
```

> ⚠️ Ganti AWS credentials dengan milik Anda dari AWS Console

### 3️⃣ Run Migrations (1 menit)

```bash
php artisan migrate
```

**Tabel yang dibuat:**
- ✅ `jobs` - Queue jobs storage
- ✅ `failed_jobs` - Error tracking
- ✅ `student_certificates` - Generated certificates
- ✅ `failed_certificates` - Certificate errors

### 4️⃣ Add Routes (1 menit)

Tambahkan ke `backend/routes/web.php`:

```php
use App\Http\Controllers\MateriController;

Route::post('/materi/upload', [MateriController::class, 'uploadMateri'])->name('materi.upload');
Route::post('/materi/mark-complete', [MateriController::class, 'markCourseComplete'])->name('materi.mark-complete');
Route::get('/materi/{id}', [MateriController::class, 'show'])->name('materi.show');
Route::get('/materi/{id}/download', [MateriController::class, 'downloadMateri'])->name('materi.download');
Route::delete('/materi/{id}', [MateriController::class, 'deleteMateri'])->name('materi.delete');
```

### 5️⃣ Start Queue Worker

**Development (Monitor Real-time):**

```bash
php artisan queue:work database --timeout=120 --verbose
```

**Atau Test Satu Job Saja:**

```bash
php artisan queue:work --once
```

---

## 🧪 TEST IT

### Upload Materi Form

```html
<form action="{{ route('materi.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="judul" placeholder="Judul Materi" required>
    <input type="file" name="file_materi" accept="audio/*,video/*,.pdf" required>
    <input type="hidden" name="course_id" value="1">
    <button type="submit">Upload</button>
</form>
```

### Test Certificate Generation

```javascript
fetch('/materi/mark-complete', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        student_id: 123,
        course_id: 456
    })
})
.then(r => r.json())
.then(d => alert(d.message));
```

**Expected Response:**
```
✅ Kursus ditandai selesai. Sertifikat sedang diproses di latar belakang...
```

---

## ✅ WHAT'S BEEN DONE

**Packages Installed:**
- ✅ `league/flysystem-aws-s3-v3` - S3 driver
- ✅ `barryvdh/laravel-dompdf` - PDF generator
- ✅ `aws/aws-sdk-php` - AWS SDK

**Files Created:**
- ✅ `app/Jobs/GenerateCertificateJob.php` - Background job
- ✅ `app/Http/Controllers/MateriController.php` - Updated with S3 methods
- ✅ `app/Mail/CertificateReady.php` - Email notification
- ✅ `resources/views/certificate/template.blade.php` - Certificate design
- ✅ `resources/views/materi/show.blade.php` - Media player
- ✅ `resources/views/emails/certificate-ready.blade.php` - Email template
- ✅ Database migrations (jobs & certificates tables)

**Documentation:**
- ✅ `IMPLEMENTATION_GUIDE_FINAL.md` - Full guide
- ✅ `S3_QUEUE_IMPLEMENTATION_GUIDE.md` - Detailed steps
- ✅ `QUEUE_S3_SETUP.md` - Reference
- ✅ `ROUTES_EXAMPLE.php` - Routes examples
- ✅ `README_INDEX.md` - Navigation
- ✅ `SETUP_SUMMARY.md` - Overview

---

## 📊 HOW IT WORKS

```
User: "Saya sudah selesai kursus"
        ↓
Controller: Update database + Dispatch job to queue
        ↓
HTTP Response: ✅ Instant (user sees message immediately)
        ↓
Background: Queue worker generates PDF → Upload to S3 → Save URL → Send email
        ↓
Result: ✅ Sertifikat siap (tanpa block HTTP request!)
```

---

## 🔍 MONITORING

```bash
# Check queue status
php artisan queue:count

# See failed jobs
php artisan queue:failed

# Retry failed job
php artisan queue:retry 1

# View logs
tail -f storage/logs/laravel.log
```

---

## ⚠️ PRODUCTION SETUP

For production, setup Supervisor to keep queue worker running:

```ini
[program:laravel-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/backend/artisan queue:work database --tries=3 --timeout=120
autostart=true
autorestart=true
numprocs=4
user=www-data
```

Then:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-queue:*
```

---

## 📚 FULL DOCUMENTATION

For complete details, see:
- `IMPLEMENTATION_GUIDE_FINAL.md` - Full guide with troubleshooting
- `README_INDEX.md` - File index & navigation

---

**Time to Setup:** ~5-10 minutes  
**All Files:** ✅ Ready  
**Status:** 🚀 Ready to Launch
