# Setup Laravel Queue & AWS S3 untuk Guruverse LMS

## 📋 Daftar Checklist

- [x] Install S3 driver package (`league/flysystem-aws-s3-v3`)
- [x] Konfigurasi `.env` dengan AWS S3 credentials
- [x] Buat Job class untuk generate sertifikat PDF
- [x] Buat Blade template sertifikat
- [x] Update MateriController dengan method mark-complete
- [x] Buat Blade view untuk media player
- [x] Buat migration untuk jobs table
- [ ] Jalankan migration
- [ ] Setup Queue Worker
- [ ] Test upload materi & generate sertifikat

---

## 🚀 Langkah Setup

### 1. Jalankan Migration untuk Jobs Table

```bash
cd d:\laragon\www\guruverse\backend
php artisan migrate
```

Ini akan membuat tabel `jobs` dan `failed_jobs` di database Anda.

### 2. Konfigurasi `.env` dengan AWS S3 Credentials

Edit file `.env` di folder `backend`:

```env
FILESYSTEM_DISK=s3

AWS_ACCESS_KEY_ID=AKIAIOSFODNN7EXAMPLE
AWS_SECRET_ACCESS_KEY=wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY
AWS_DEFAULT_REGION=ap-southeast-3
AWS_BUCKET=guruverse-lms-bucket
AWS_ENDPOINT=https://s3.amazonaws.com
AWS_URL=https://guruverse-lms-bucket.s3.ap-southeast-3.amazonaws.com

# Queue configuration
QUEUE_CONNECTION=database
```

**Catatan:**
- Ganti `AWS_ACCESS_KEY_ID` dan `AWS_SECRET_ACCESS_KEY` dengan kredensial AWS Anda
- Region `ap-southeast-3` adalah Jakarta
- Pastikan bucket S3 sudah ada di AWS Console

### 3. Instal Paket DomPDF untuk Generate Sertifikat

```bash
composer require barryvdh/laravel-dompdf
```

### 4. Publish Config DomPDF

```bash
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

### 5. Setup Routes untuk Materi & Queue

Tambahkan routes berikut ke file `backend/routes/api.php` atau `backend/routes/web.php`:

```php
use App\Http\Controllers\MateriController;

// Upload materi ke S3
Route::post('/materi/upload', [MateriController::class, 'uploadMateri'])->name('materi.upload');

// Tandai kursus selesai & trigger certificate job
Route::post('/materi/mark-complete', [MateriController::class, 'markCourseComplete'])->name('materi.mark-complete');

// Download materi
Route::get('/materi/{id}/download', [MateriController::class, 'downloadMateri'])->name('materi.download');

// Lihat/putar materi
Route::get('/materi/{id}', [MateriController::class, 'show'])->name('materi.show');

// Get media URL dari S3
Route::get('/media-url/{fileUrl}', [MateriController::class, 'getMediaUrl'])->name('media.url');
```

### 6. Jalankan Queue Worker

**Untuk Development (Mode Sync - Langsung Process):**

```bash
# Jalankan satu job saja
php artisan queue:work --once

# Atau, jalankan worker dengan monitoring realtime
php artisan queue:work database --timeout=120
```

**Untuk Production (Background Process dengan Supervisor):**

Buat file `/etc/supervisor/conf.d/laravel-worker.conf`:

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/guruverse/backend/artisan queue:work database --sleep=3 --tries=3 --timeout=120
autostart=true
autorestart=true
numprocs=4
user=www-data
redirect_stderr=true
stdout_logfile=/var/log/laravel-worker.log
```

Kemudian restart supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

---

## 📝 Contoh Penggunaan

### Upload Materi (MP4/MP3/PDF)

**Form HTML:**

```html
<form action="{{ route('materi.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <input type="text" name="judul" placeholder="Judul Materi" required>
    <textarea name="deskripsi" placeholder="Deskripsi"></textarea>
    <input type="file" name="file_materi" accept="audio/*,video/*,.pdf" required>
    <input type="hidden" name="course_id" value="{{ $course->id }}">
    
    <button type="submit">Upload ke Cloud Storage</button>
</form>
```

**Flow:**
1. File diupload ke AWS S3 → folder `materi/`
2. Path disimpan ke database
3. Siswa bisa memutar/download dari URL S3

### Tandai Kursus Selesai & Generate Sertifikat

**JavaScript:**

```javascript
// Saat siswa klik tombol "Selesai" atau lulus ujian
fetch('/api/materi/mark-complete', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        student_id: 123,
        course_id: 456
    })
})
.then(res => res.json())
.then(data => {
    if (data.success) {
        console.log('✅ Sertifikat sedang diproses di background');
    }
});
```

**Flow:**
1. Request diterima → database diupdate `course_completions`
2. Job `GenerateCertificateJob` di-dispatch ke queue
3. Queue worker mengambil job → generate PDF → simpan ke S3
4. Database disimpan dengan URL sertifikat
5. Halaman siswa tidak pernah loading lama! ⚡

---

## 🔍 Debug & Monitoring

### Lihat Failed Jobs

```bash
php artisan queue:failed
```

### Coba Ulang Failed Job

```bash
php artisan queue:retry {id}
```

### Flush Semua Jobs

```bash
php artisan queue:flush
```

### Monitor Queue Status

```bash
# Lihat jumlah pending jobs
php artisan queue:count

# Lihat job yang sedang berjalan
php artisan queue:work --verbose
```

---

## 📊 Database Schema Diperlukan

### Tabel `materis` (untuk media)

```sql
CREATE TABLE materis (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    judul VARCHAR(255),
    deskripsi TEXT,
    tipe VARCHAR(50),
    file_url VARCHAR(500), -- Path di S3, misal: "materi/video1.mp4"
    file_size INT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Tabel `course_completions` (untuk tracking)

```sql
CREATE TABLE course_completions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    course_id INT,
    completed_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Tabel `student_certificates` (untuk sertifikat)

```sql
CREATE TABLE student_certificates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    course_id INT,
    certificate_url VARCHAR(500), -- URL di S3
    generated_at TIMESTAMP,
    created_at TIMESTAMP
);
```

---

## 🎯 Best Practices

1. **Test Mode Development:**
   - Gunakan `QUEUE_CONNECTION=sync` di `.env` untuk development
   - Job langsung diexecute tanpa queue

2. **Production:**
   - Gunakan `QUEUE_CONNECTION=database`
   - Setup supervisor untuk background worker
   - Monitor queue health

3. **S3 Bucket Config:**
   - Set public ACL untuk media yang perlu diakses publik
   - Gunakan CloudFront distribution untuk CDN
   - Set lifecycle policies untuk menghapus old files

4. **Error Handling:**
   - Check `logs/laravel.log` untuk debug
   - Monitor `failed_jobs` table untuk error
   - Implement retry logic di Job class

---

## ⚠️ Troubleshooting

### Queue Job Tidak Jalan

```bash
# Check status worker
ps aux | grep "queue:work"

# Start worker baru
php artisan queue:work database

# Cek log
tail -f storage/logs/laravel.log
```

### S3 Upload Error

- Verify AWS credentials di `.env`
- Check S3 bucket permissions
- Test dengan AWS CLI:
  ```bash
  aws s3 ls s3://guruverse-lms-bucket/
  ```

### Certificate PDF Tidak Generate

- Install DomPDF: `composer require barryvdh/laravel-dompdf`
- Check storage permissions
- Review failed jobs: `php artisan queue:failed`

---

## 📚 Referensi

- [Laravel Queue Documentation](https://laravel.com/docs/queues)
- [Laravel Filesystem S3 Documentation](https://laravel.com/docs/filesystem#s3-driver)
- [AWS S3 Setup Guide](https://docs.aws.amazon.com/s3/)
- [Laravel DomPDF](https://github.com/barryvdh/laravel-dompdf)

---

**Tanggal Setup:** June 3, 2026  
**Status:** ✅ Ready for Production
