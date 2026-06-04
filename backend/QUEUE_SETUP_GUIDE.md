# 📋 Panduan Setup Queue & Certificate Generation di Guruverse

## 📌 Overview
Dokumentasi ini menjelaskan cara mengintegrasikan **Laravel Queue** untuk membuat sertifikat PDF secara asynchronous (di latar belakang) saat siswa menyelesaikan kursus.

---

## ✅ Step 1: Konfigurasi `.env` (SUDAH DILAKUKAN)

File `.env` di root project sudah diperbarui dengan konfigurasi berikut:

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

### Penjelasan Konfigurasi:
- **FILESYSTEM_DISK=s3**: Menggunakan S3 sebagai storage utama untuk file media
- **QUEUE_CONNECTION=database**: Menggunakan database untuk queue (bisa juga gunakan `redis` untuk production)
- **AWS_***: Credensial AWS S3 Anda

---

## ✅ Step 2: Install Dependencies (SUDAH DILAKUKAN)

Package yang sudah diinstal:
```bash
composer require league/flysystem-aws-s3-v3 "^3.0"
```

Package yang mungkin diperlukan (install jika belum):
```bash
composer require barryvdh/laravel-dompdf
```

---

## 📝 Step 3: Setup Database Queue Table

Jalankan perintah untuk membuat tabel queue di database:

```bash
cd backend
php artisan queue:table
php artisan migrate
```

Ini akan membuat tabel `jobs` dan `failed_jobs` di database Anda.

---

## 🏗️ Struktur File yang Sudah Dibuat

### 1. **Job: `app/Jobs/GenerateCertificate.php`**
Ini adalah Job yang akan membuat sertifikat PDF dan menyimpannya ke S3.

**Fitur:**
- Menerima data siswa, kursus, dan tanggal penyelesaian
- Generate PDF dari template Blade
- Upload PDF ke S3 Cloud Storage
- Simpan informasi sertifikat ke database (opsional)
- Error handling dan logging

### 2. **Event: `app/Events/CourseCompleted.php`**
Event yang di-dispatch ketika siswa menyelesaikan kursus.

### 3. **Listener: `app/Listeners/SendCertificateOnCompletion.php`**
Listener yang mendengarkan event `CourseCompleted` dan dispatch Job `GenerateCertificate`.

### 4. **Controller: `app/Http/Controllers/MateriController.php`**
Contoh controller untuk upload materi ke S3.

**Fitur:**
- `uploadMateri()`: Upload file MP3/MP4/PDF ke S3
- `downloadMateri()`: Download file dari S3
- `deleteMateri()`: Hapus file dari S3

### 5. **Template Blade: `resources/views/certificates/template.blade.php`**
Template HTML/CSS untuk desain sertifikat PDF yang cantik.

---

## 🚀 Cara Menggunakan

### 1. **Trigger Certificate Generation saat Siswa Menyelesaikan Kursus**

Di Controller Anda (misalnya `CompleteCourseController` atau di mana logika completion ada):

```php
<?php

namespace App\Http\Controllers;

use App\Events\CourseCompleted;
use Illuminate\Http\Request;

class CompleteCourseController extends Controller
{
    public function completeQuiz(Request $request)
    {
        // ... logika verifikasi bahwa siswa sudah menyelesaikan semua kuis & ujian

        // Jika siswa lulus, trigger event
        if ($allQuizzesPassed) {
            event(new CourseCompleted(
                studentId: auth()->id(),
                courseId: $request->course_id,
                studentName: auth()->user()->name,
                courseName: $course->name
            ));

            return response()->json(['message' => 'Kursus selesai! Sertifikat sedang dibuat...']);
        }
    }
}
```

### 2. **Upload Materi ke S3**

Menggunakan `MateriController` yang sudah ada:

```php
// Route
Route::post('/materi/upload', [MateriController::class, 'uploadMateri'])->middleware('auth');

// Form Blade
<form action="{{ route('materi.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="judul" placeholder="Judul Materi" required>
    <input type="text" name="deskripsi" placeholder="Deskripsi (opsional)">
    <input type="number" name="course_id" required>
    <input type="file" name="file_materi" accept=".mp3,.mp4,.pdf" required>
    <button type="submit">Upload</button>
</form>
```

### 3. **Menampilkan Video/Audio di Blade (untuk Siswa)**

```html
<!-- Video -->
<video width="100%" controls>
    <source src="{{ Storage::disk('s3')->url($materi->file_url) }}" type="video/mp4">
    Browser Anda tidak mendukung pemutar video.
</video>

<!-- Audio -->
<audio controls style="width: 100%;">
    <source src="{{ Storage::disk('s3')->url($materi->file_url) }}" type="audio/mpeg">
    Browser Anda tidak mendukung pemutar audio.
</audio>

<!-- Download PDF -->
<a href="{{ route('materi.download', $materi->id) }}" class="btn btn-primary">Download PDF</a>
```

---

## 🔄 Running Queue Worker

Untuk proses Job yang ada di queue, Anda perlu menjalankan queue worker:

```bash
# Development (foreground)
php artisan queue:work

# Production (dengan supervisor - recommended)
php artisan queue:work --daemon
```

### Konfigurasi Supervisor untuk Production:

Buat file `/etc/supervisor/conf.d/guruverse-worker.conf`:

```ini
[program:guruverse-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/guruverse/backend/artisan queue:work --queue=default --sleep=3 --tries=3
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/guruverse-worker.log
stopwaitsecs=3600
```

Restart supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start guruverse-worker:*
```

---

## 🎯 Workflow Lengkap

### Scenario: Siswa Menyelesaikan Kursus

1. ✅ Siswa menyelesaikan semua modul, video, dan kuis
2. ✅ Sistem mendeteksi: `all_quizzes_passed = true`
3. ✅ Controller me-dispatch event `CourseCompleted`
4. ✅ Event listener `SendCertificateOnCompletion` mendengar event
5. ✅ Listener dispatch Job `GenerateCertificate` ke queue
6. ⏳ **Queue worker** mengambil Job dari queue
7. ✅ Job membuat PDF sertifikat
8. ✅ PDF di-upload ke S3
9. ✅ URL sertifikat disimpan di database
10. ✅ Siswa bisa download/view sertifikat

**Keuntungan:**
- Halaman web tidak loading lama saat membuat PDF
- Tidak ada timeout karena proses berjalan di background
- Bisa handle banyak siswa sekaligus

---

## 📊 Database Tables yang Diperlukan

Jalankan migration untuk membuat table jobs:

```bash
php artisan queue:table
php artisan migrate
```

### Table `jobs`:
```sql
CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
);
```

### Table `failed_jobs`:
```sql
CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uuid` varchar(255) NOT NULL UNIQUE,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL
);
```

---

## 🛠️ Testing Queue Locally

Untuk testing di development environment, gunakan `QUEUE_CONNECTION=sync` di `.env`:

```env
QUEUE_CONNECTION=sync
```

Dengan `sync`, Job akan dijalankan **instantly** tanpa perlu queue worker.

Setelah production, ubah ke:
```env
QUEUE_CONNECTION=database
# atau
QUEUE_CONNECTION=redis
```

---

## 📋 Checklist Setup

- ✅ Update `.env` dengan konfigurasi S3 dan Queue
- ✅ Install `league/flysystem-aws-s3-v3`
- ✅ Install `barryvdh/laravel-dompdf`
- ⏳ **Jalankan migration untuk queue table**: `php artisan queue:table && php artisan migrate`
- ⏳ **Daftarkan Event & Listener di** `app/Providers/EventServiceProvider.php`
- ⏳ **Test upload materi ke S3**
- ⏳ **Test certificate generation**
- ⏳ **Setup queue worker untuk production**

---

## 🔐 Security Notes

1. **Jangan commit `.env`** - file ini berisi credentials sensitif
2. **Gunakan IAM User** dengan limited permissions untuk AWS S3
3. **Enable CORS** di S3 bucket jika diakses dari frontend
4. **Setup SSL/HTTPS** untuk production

---

## 📞 Troubleshooting

### Error: "Class not found: GenerateCertificate"
Jalankan: `composer dump-autoload`

### Job tidak terjalankan
- Pastikan queue worker sedang berjalan
- Cek log: `php artisan queue:failed`

### PDF tidak generate
- Pastikan `barryvdh/laravel-dompdf` sudah terinstall
- Cek permission folder `storage/`

### S3 upload failed
- Verify AWS credentials
- Check S3 bucket permissions
- Verify region configuration

---

## 📚 Referensi

- [Laravel Queue Documentation](https://laravel.com/docs/queues)
- [Laravel Events Documentation](https://laravel.com/docs/events)
- [DomPDF Documentation](https://github.com/barryvdh/laravel-dompdf)
- [AWS S3 Documentation](https://docs.aws.amazon.com/s3/)

---

**Status**: ✅ Setup selesai. Siap untuk development dan testing.
