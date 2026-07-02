# 🎯 IMPLEMENTATION GUIDE: S3 + Queue untuk Guruverse LMS

**Tanggal Setup:** June 3, 2026  
**Status:** ✅ In Progress

---

## 📋 File yang Sudah Dibuat/Diupdate

### 1. ✅ **Job Classes** (`app/Jobs/`)
- `GenerateCertificateJob.php` - Job untuk generate sertifikat PDF di background
  - Menggunakan DomPDF untuk membuat PDF
  - Auto-retry 3x jika gagal
  - Timeout 120 detik
  - Simpan ke S3 dan database

### 2. ✅ **Blade Templates** (`resources/views/`)
- `certificate/template.blade.php` - Template desain sertifikat
- `materi/show.blade.php` - Media player (video/audio/PDF)
- `emails/certificate-ready.blade.php` - Email notifikasi

### 3. ✅ **Controllers** (`app/Http/Controllers/`)
- `MateriController.php` - Updated dengan method:
  - `uploadMateri()` - Upload ke S3
  - `markCourseComplete()` - Trigger certificate job
  - `getMediaUrl()` - Ambil URL dari S3
  - `downloadMateri()` - Download file
  - `deleteMateri()` - Delete file

### 4. ✅ **Migrations** (`database/migrations/`)
- `2024_01_01_000000_create_jobs_table.php` - Tabel jobs & failed_jobs
- `2024_01_02_000000_create_certificate_tables.php` - Tabel student_certificates & failed_certificates

### 5. ✅ **Mail Classes** (`app/Mail/`)
- `CertificateReady.php` - Mailable untuk kirim email notifikasi

### 6. ✅ **Documentation** (root folder)
- `QUEUE_S3_SETUP.md` - Setup guide lengkap
- `ROUTES_EXAMPLE.php` - Contoh routes implementation

---

## 🚀 LANGKAH-LANGKAH SETUP BERIKUTNYA

### Step 1: Tunggu Composer Selesai ⏳
```bash
# Composer sedang menginstal:
✅ league/flysystem-aws-s3-v3
⏳ barryvdh/laravel-dompdf (sedang berjalan...)
```

### Step 2: Publish DomPDF Config (Setelah Composer Selesai)
```bash
cd d:\laragon\www\guruverse\backend
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

### Step 3: Setup AWS S3 Credentials di `.env`

Edit file `.env` backend:

```env
# ─── Cloud Storage Configuration (AWS S3) ─────────────
FILESYSTEM_DISK=s3

AWS_ACCESS_KEY_ID=AKIAIOSFODNN7EXAMPLE
AWS_SECRET_ACCESS_KEY=wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY
AWS_DEFAULT_REGION=ap-southeast-3
AWS_BUCKET=guruverse-lms-bucket
AWS_ENDPOINT=https://s3.amazonaws.com
AWS_URL=https://guruverse-lms-bucket.s3.ap-southeast-3.amazonaws.com

# ─── Queue Configuration ────────────────────────────────
QUEUE_CONNECTION=database
```

### Step 4: Jalankan Migrations
```bash
php artisan migrate
```

Ini akan membuat:
- `jobs` table (untuk queue)
- `failed_jobs` table (untuk failed jobs)
- `student_certificates` table (untuk sertifikat)
- `failed_certificates` table (untuk track error)

### Step 5: Setup Routes

Tambahkan ke `backend/routes/web.php` atau `backend/routes/api.php`:

```php
use App\Http\Controllers\MateriController;

// Student routes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::post('/materi/mark-complete', [MateriController::class, 'markCourseComplete'])->name('materi.mark-complete');
    Route::get('/materi/{id}', [MateriController::class, 'show'])->name('materi.show');
    Route::get('/materi/{id}/download', [MateriController::class, 'downloadMateri'])->name('materi.download');
});

// Teacher routes
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::post('/materi/upload', [MateriController::class, 'uploadMateri'])->name('materi.upload');
    Route::delete('/materi/{id}', [MateriController::class, 'deleteMateri'])->name('materi.delete');
});
```

### Step 6: **⚡ CRITICAL: Jalankan Queue Worker**

**UNTUK DEVELOPMENT (Mode 1 - Auto-execute):**
```bash
# Jalankan satu job dan exit (testing)
php artisan queue:work --once

# Atau jalankan worker yang terus monitoring queue
php artisan queue:work database --timeout=120 --verbose
```

**UNTUK PRODUCTION (Mode 2 - Background Process):**

Instal & setup Supervisor (Linux):
```bash
# Edit file config supervisor
sudo nano /etc/supervisor/conf.d/laravel-queue.conf
```

Paste config ini:
```ini
[program:laravel-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/backend/artisan queue:work database --tries=3 --timeout=120
autostart=true
autorestart=true
numprocs=4
user=www-data
```

Reload supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-queue:*
```

### Step 7: Test Upload & Certificate Generation

**Test Form Upload:**
```html
<form action="{{ route('materi.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="judul" placeholder="Judul" required>
    <input type="file" name="file_materi" accept="audio/*,video/*,.pdf" required>
    <input type="hidden" name="course_id" value="1">
    <button type="submit">Upload</button>
</form>
```

**Test Certificate Generation:**
```javascript
fetch('/api/materi/mark-complete', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
    },
    body: JSON.stringify({
        student_id: 123,
        course_id: 456
    })
})
.then(r => r.json())
.then(d => console.log(d.message));
```

---

## 🔍 MONITORING & DEBUGGING

### Lihat Status Queue
```bash
# Jumlah pending jobs
php artisan queue:count

# List failed jobs
php artisan queue:failed

# Lihat job yang sedang diproses (verbose)
php artisan queue:work database --verbose
```

### Retry Failed Job
```bash
# Retry satu job
php artisan queue:retry 1

# Retry semua failed jobs
php artisan queue:retry all

# Lihat error detail
php artisan queue:failed-show 1
```

### View Logs
```bash
tail -f storage/logs/laravel.log
```

---

## 📊 DATABASE SCHEMA REFERENCE

### Tabel: `jobs` (Queue Storage)
```sql
CREATE TABLE jobs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    queue VARCHAR(255),
    payload LONGTEXT,
    attempts TINYINT UNSIGNED DEFAULT 0,
    reserved_at INT UNSIGNED,
    available_at INT UNSIGNED,
    created_at INT UNSIGNED,
    INDEX idx_queue (queue),
    INDEX idx_reserved (reserved_at)
);
```

### Tabel: `student_certificates`
```sql
CREATE TABLE student_certificates (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    student_id BIGINT,
    course_id BIGINT,
    certificate_url VARCHAR(500),
    certificate_filename VARCHAR(500),
    generated_at TIMESTAMP,
    downloaded_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE KEY unique_student_course (student_id, course_id),
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);
```

---

## ⚠️ COMMON ISSUES & SOLUTIONS

| Masalah | Solusi |
|---------|--------|
| **Queue job tidak jalan** | Pastikan `php artisan queue:work` berjalan di background |
| **S3 upload error** | Verify AWS credentials & bucket permissions |
| **PDF tidak generate** | Install DomPDF: `composer require barryvdh/laravel-dompdf` |
| **Email tidak terkirim** | Check SMTP config di `.env` |
| **Memory limit exceeded** | Increase PHP memory: `memory_limit = 512M` di php.ini |

---

## 📝 CHECKLIST IMPLEMENTASI

- [ ] Composer packages selesai install (S3 + DomPDF)
- [ ] Publish DomPDF config
- [ ] Update `.env` dengan AWS S3 credentials
- [ ] Jalankan migrations
- [ ] Setup routes di routes/web.php
- [ ] Setup Queue Worker (development atau production)
- [ ] Test upload materi
- [ ] Test certificate generation
- [ ] Verify email notifications
- [ ] Setup logging & monitoring
- [ ] Deploy ke production

---

## 🔗 NEXT STEPS

1. ✅ **S3 Bucket Setup** - Buat bucket di AWS Console
2. ✅ **IAM Credentials** - Generate access key & secret
3. ✅ **Queue Worker** - Setup background process
4. ✅ **Email Config** - Setup SMTP/Mailtrap
5. ✅ **Database** - Run migrations
6. ✅ **Testing** - Test end-to-end flow

---

**Dokumentasi Lengkap:** Lihat file `QUEUE_S3_SETUP.md`  
**Contoh Routes:** Lihat file `ROUTES_EXAMPLE.php`
