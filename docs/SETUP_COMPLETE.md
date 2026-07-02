# 🎓 SETUP LENGKAP: AWS S3 Storage & Laravel Queue untuk Sertifikat Guruverse

**Status**: ✅ SELESAI - Semua file dan konfigurasi sudah siap!

---

## 📋 Ringkasan Perubahan

### 1. ✅ Konfigurasi Environment (`.env`)

**File**: `.env` (di root project)

Ditambahkan:
```env
# Cloud Storage Configuration (AWS S3)
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_access_key_id
AWS_SECRET_ACCESS_KEY=your_secret_access_key
AWS_DEFAULT_REGION=ap-southeast-3
AWS_BUCKET=your-bucket-name
AWS_ENDPOINT=https://s3.amazonaws.com

# Laravel Queue Configuration
QUEUE_CONNECTION=database
```

**Action Needed**: Ganti nilai `your_access_key_id`, `your_secret_access_key`, dan `your-bucket-name` dengan kredensial AWS S3 Anda.

---

### 2. ✅ Composer Dependencies

**Installed**:
- `league/flysystem-aws-s3-v3 ^3.0` ← untuk AWS S3 integration

**Need to Install**:
```bash
cd backend
composer require barryvdh/laravel-dompdf
```

---

### 3. ✅ File Structure yang Dibuat

```
backend/
├── app/
│   ├── Events/
│   │   └── CourseCompleted.php          ← Event saat siswa selesai course
│   ├── Listeners/
│   │   └── SendCertificateOnCompletion.php  ← Trigger Job dari event
│   ├── Jobs/
│   │   └── GenerateCertificate.php      ← Job untuk generate PDF di background
│   ├── Http/Controllers/
│   │   ├── MateriController.php         ← Upload/Download/Delete materi ke S3
│   │   └── CertificateController.php    ← View/Download sertifikat
│   ├── Models/
│   │   ├── Materi.php                   ← Model untuk materi pembelajaran
│   │   ├── Certificate.php              ← Model untuk sertifikat
│   │   └── EventServiceProvider.php     ← Provider untuk event & listener
│   └── Providers/
│       └── EventServiceProvider.php     ← Registrasi event & listener
├── database/
│   └── migrations/
│       ├── 2024_06_03_000001_create_materis_table.php
│       └── 2024_06_03_000002_create_certificates_table.php
├── resources/
│   └── views/
│       └── certificates/
│           └── template.blade.php       ← Template design sertifikat PDF
├── routes/
│   └── queue-routes-example.php         ← Contoh routes (copy ke web.php/api.php)
└── QUEUE_SETUP_GUIDE.md                 ← Panduan lengkap setup
```

---

## 🚀 Step-by-Step Setup Instructions

### Step 1: Konfigurasi AWS S3

1. Buka AWS Console: https://console.aws.amazon.com
2. Navigasi ke **S3** → **Create Bucket**
3. Buat bucket dengan nama: `guruverse-lms-bucket` (atau nama pilihan Anda)
4. Di bucket settings:
   - Enable CORS jika diperlukan frontend access
   - Buat IAM User dengan S3 permissions
5. Copy credentials ke `.env`:
   ```env
   AWS_ACCESS_KEY_ID=AKIAIOSFODNN7EXAMPLE
   AWS_SECRET_ACCESS_KEY=wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY
   AWS_BUCKET=guruverse-lms-bucket
   ```

### Step 2: Install DomPDF (untuk PDF Generation)

```bash
cd backend
composer require barryvdh/laravel-dompdf
```

### Step 3: Create Database Tables

```bash
cd backend
php artisan queue:table
php artisan migrate
```

Perintah ini membuat:
- Table `jobs` (untuk queue)
- Table `failed_jobs` (untuk error tracking)
- Table `materis` (untuk materi pembelajaran)
- Table `certificates` (untuk sertifikat)

### Step 4: Daftarkan Event & Listener

**File**: `backend/config/app.php`

Pastikan provider ini ada di array `providers`:
```php
App\Providers\EventServiceProvider::class,
```

Jika belum ada, tambahkan ke `bootstrap/app.php` atau `config/app.php`.

### Step 5: Tambahkan Routes

Copy isi dari `routes/queue-routes-example.php` ke `routes/web.php` atau `routes/api.php`:

```php
// Upload Materi
Route::post('/materi/upload', [MateriController::class, 'uploadMateri'])
    ->name('materi.upload')
    ->middleware('auth');

// Download/View Sertifikat
Route::get('/certificates/{id}', [CertificateController::class, 'show'])
    ->name('certificates.show')
    ->middleware('auth');

Route::get('/certificates/{id}/download', [CertificateController::class, 'download'])
    ->name('certificates.download')
    ->middleware('auth');
```

---

## 💻 Cara Menggunakan

### A. Upload Materi dari Guru

**Trigger Point**: Saat guru mengklik tombol upload di form materi

```php
// Di Controller
$path = $request->file('file_materi')->store('materi', 's3');

Materi::create([
    'judul' => $request->judul,
    'tipe' => $request->file('file_materi')->getClientOriginalExtension(),
    'file_url' => $path, // Simpan ke DB
    'course_id' => $request->course_id,
]);
```

**Hasil**: File MP3/MP4 disimpan di S3, hanya path yang disimpan di DB.

### B. Siswa Menonton Video/Audio

**Trigger Point**: Siswa membuka halaman materi

```html
<video controls width="100%">
    <source src="{{ Storage::disk('s3')->url($materi->file_url) }}" type="video/mp4">
</video>

<!-- Atau -->
<audio controls>
    <source src="{{ Storage::disk('s3')->url($materi->file_url) }}" type="audio/mpeg">
</audio>
```

### C. Siswa Selesai Course → Generate Sertifikat

**Trigger Point**: Saat sistem mendeteksi siswa lulus ujian akhir

```php
// Di Controller (misal CompleteCourseController)
use App\Events\CourseCompleted;

event(new CourseCompleted(
    studentId: auth()->id(),
    courseId: $request->course_id,
    studentName: auth()->user()->name,
    courseName: $course->name
));
```

**Workflow**:
1. Event `CourseCompleted` di-dispatch
2. Listener `SendCertificateOnCompletion` mendengarkan event
3. Listener dispatch Job `GenerateCertificate` ke queue
4. **Queue worker** mengambil Job dari database
5. Job membuat PDF dari template
6. PDF di-upload ke S3
7. URL disimpan ke table `certificates`
8. Siswa bisa download sertifikat

### D. Siswa Download Sertifikat

**Trigger Point**: Siswa klik tombol "Download Sertifikat"

```blade
<a href="{{ route('certificates.download', $certificate->id) }}" 
   class="btn btn-primary">
    Download Sertifikat
</a>
```

---

## 🔄 Running Queue Worker

Untuk meng-eksekusi Job yang ada di queue:

### Development (Foreground):
```bash
cd backend
php artisan queue:work
```

### Production (dengan Supervisor):

**1. Buat file supervisor** `/etc/supervisor/conf.d/guruverse-worker.conf`:
```ini
[program:guruverse-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/guruverse/backend/artisan queue:work --queue=default --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/guruverse-worker.log
```

**2. Restart Supervisor**:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start guruverse-worker:*
```

---

## ✨ Model Relationships

### Materi Model
```php
$materi->course();      // Course yang dimiliki materi
$materi->uploadedBy();  // User yang upload
```

### Certificate Model
```php
$cert->student();       // User yang dapat sertifikat
$cert->course();        // Course yang diselesaikan
```

---

## 📝 Database Schema

### Materis Table
```sql
id | judul | deskripsi | tipe | file_url | course_id | uploaded_by | durasi | created_at
```

### Certificates Table
```sql
id | student_id | course_id | file_url | certificate_number | issued_at | created_at
```

### Jobs Table (untuk Queue)
```sql
id | queue | payload | attempts | reserved_at | available_at | created_at
```

---

## 🧪 Testing Locally

Untuk testing tanpa perlu queue worker:

**Ubah `.env`**:
```env
QUEUE_CONNECTION=sync
```

Dengan `sync`, Job akan dijalankan **instantly**. Ubah kembali ke `database` saat production.

---

## ⚠️ Troubleshooting

### Error: "Class 'App\Jobs\GenerateCertificate' not found"
**Solusi**:
```bash
cd backend
composer dump-autoload
```

### Job tidak terjalankan
**Check**:
1. Pastikan queue worker sedang berjalan: `php artisan queue:work`
2. Lihat failed jobs: `php artisan queue:failed`
3. Cek table `jobs` di database

### PDF tidak generate
**Check**:
1. `barryvdh/laravel-dompdf` sudah terinstall?
   ```bash
   composer require barryvdh/laravel-dompdf
   ```
2. File `resources/views/certificates/template.blade.php` ada?
3. Folder `storage/` memiliki permission write?

### S3 Upload Failed
**Check**:
1. AWS credentials di `.env` benar?
2. S3 bucket sudah dibuat?
3. IAM User punya permission s3:PutObject?

---

## 🔐 Security Checklist

- ✅ `.env` di dalam `.gitignore` (jangan commit!)
- ✅ Gunakan IAM User dengan limited permissions
- ✅ Enable CORS di S3 bucket jika diperlukan
- ✅ Setup SSL/HTTPS di production
- ✅ Validasi file type sebelum upload
- ✅ Set max file size limit (100MB di contoh)

---

## 📚 File Documentation

| File | Purpose |
|------|---------|
| `.env` | Konfigurasi environment & AWS S3 |
| `backend/app/Jobs/GenerateCertificate.php` | Job untuk generate sertifikat PDF |
| `backend/app/Events/CourseCompleted.php` | Event ketika course selesai |
| `backend/app/Listeners/SendCertificateOnCompletion.php` | Listener yang trigger Job |
| `backend/app/Http/Controllers/MateriController.php` | Controller upload/download materi |
| `backend/app/Http/Controllers/CertificateController.php` | Controller untuk sertifikat |
| `backend/app/Models/Materi.php` | Model database materi |
| `backend/app/Models/Certificate.php` | Model database sertifikat |
| `backend/app/Providers/EventServiceProvider.php` | Registrasi Event & Listener |
| `backend/resources/views/certificates/template.blade.php` | Template design sertifikat PDF |
| `backend/database/migrations/2024_06_03_000001_create_materis_table.php` | Migration untuk tabel materis |
| `backend/database/migrations/2024_06_03_000002_create_certificates_table.php` | Migration untuk tabel certificates |
| `backend/routes/queue-routes-example.php` | Contoh routes (copy ke web.php) |
| `backend/QUEUE_SETUP_GUIDE.md` | Panduan setup lengkap |

---

## 🎯 Next Steps

1. ✅ **Update `.env`** dengan AWS credentials
2. ✅ **Install DomPDF**: `composer require barryvdh/laravel-dompdf`
3. ✅ **Run migrations**: `php artisan migrate`
4. ✅ **Copy routes** dari `queue-routes-example.php` ke `web.php`
5. ✅ **Start queue worker**: `php artisan queue:work` (dev) atau setup supervisor (production)
6. ✅ **Test upload materi** ke S3
7. ✅ **Test certificate generation** trigger
8. ✅ **Test download sertifikat** dari siswa

---

## 📞 Support

Jika ada error:
1. Cek file log: `backend/storage/logs/laravel.log`
2. Cek database: `SELECT * FROM failed_jobs;`
3. Cek queue: `php artisan queue:failed`

---

**Setup Version**: 1.0  
**Last Updated**: June 3, 2024  
**Laravel Version**: 10/11+  
**PHP Version**: 8.1+
