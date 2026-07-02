# ✅ CHECKLIST IMPLEMENTASI: AWS S3 & Laravel Queue untuk Sertifikat

**Project**: Guruverse LMS  
**Date**: June 3, 2024  
**Status**: Setup Files Completed ✅

---

## 📋 Phase 1: Environment & Configuration

- [x] Update `.env` dengan konfigurasi S3
  - [ ] Ganti `AWS_ACCESS_KEY_ID` dengan nilai real
  - [ ] Ganti `AWS_SECRET_ACCESS_KEY` dengan nilai real
  - [ ] Ganti `AWS_BUCKET` dengan nama bucket S3 Anda
  - [ ] Verifikasi `AWS_DEFAULT_REGION=ap-southeast-3`

- [x] Installer Composer dependencies
  - [x] `league/flysystem-aws-s3-v3 ^3.0` ✅ (sudah diinstall)
  - [ ] `barryvdh/laravel-dompdf` (perlu diinstall)

---

## 📦 Phase 2: Database Setup

- [ ] Jalankan pembuatan queue table
  ```bash
  cd backend
  php artisan queue:table
  ```

- [ ] Jalankan migration
  ```bash
  php artisan migrate
  ```

- [ ] Verifikasi tables terbuat:
  - [ ] `jobs` table
  - [ ] `failed_jobs` table
  - [ ] `materis` table
  - [ ] `certificates` table

---

## 🏗️ Phase 3: File Integration

### Models & Controllers
- [x] `app/Models/Materi.php` ✅
- [x] `app/Models/Certificate.php` ✅
- [x] `app/Http/Controllers/MateriController.php` ✅
- [x] `app/Http/Controllers/CertificateController.php` ✅

### Events & Listeners
- [x] `app/Events/CourseCompleted.php` ✅
- [x] `app/Listeners/SendCertificateOnCompletion.php` ✅
- [x] `app/Providers/EventServiceProvider.php` ✅

- [ ] Verifikasi EventServiceProvider ter-register di `config/app.php`
  - [ ] Tambahkan ke `providers` array jika belum ada

### Jobs & Views
- [x] `app/Jobs/GenerateCertificate.php` ✅
- [x] `resources/views/certificates/template.blade.php` ✅

### Routes
- [ ] Copy routes dari `routes/queue-routes-example.php`
  - [ ] Tambahkan `POST /materi/upload` route
  - [ ] Tambahkan `GET /certificates` route
  - [ ] Tambahkan `GET /certificates/{id}` route
  - [ ] Tambahkan `GET /certificates/{id}/download` route

---

## 🔧 Phase 4: Code Integration

- [ ] **Di komponen Course Completion**:
  ```php
  use App\Events\CourseCompleted;
  
  event(new CourseCompleted($studentId, $courseId, $studentName, $courseName));
  ```

- [ ] **Di form upload materi**:
  ```blade
  <form action="{{ route('materi.upload') }}" method="POST" enctype="multipart/form-data">
    {{-- Gunakan form dari BLADE_TEMPLATES_EXAMPLES.blade.php --}}
  </form>
  ```

- [ ] **Di halaman untuk menampilkan video/audio**:
  ```blade
  <video controls>
    <source src="{{ Storage::disk('s3')->url($materi->file_url) }}" type="video/mp4">
  </video>
  ```

- [ ] **Di halaman list sertifikat siswa**:
  ```blade
  {{-- Gunakan template dari BLADE_TEMPLATES_EXAMPLES.blade.php --}}
  ```

---

## 🚀 Phase 5: Queue Worker Setup

### Development Environment
- [ ] Install/test paket DomPDF:
  ```bash
  cd backend
  composer require barryvdh/laravel-dompdf
  ```

- [ ] Pastikan `.env` menggunakan `QUEUE_CONNECTION=database`

- [ ] Jalankan queue worker:
  ```bash
  php artisan queue:work
  ```

- [ ] Test dengan menyelesaikan course di frontend
  - [ ] Verifikasi sertifikat ter-generate
  - [ ] Verifikasi file ter-upload ke S3
  - [ ] Verifikasi siswa bisa download sertifikat

### Production Environment
- [ ] Setup Supervisor untuk queue worker
  - [ ] Buat file `/etc/supervisor/conf.d/guruverse-worker.conf`
  - [ ] Konfigurasi dengan 4+ processes
  - [ ] Restart supervisor: `supervisorctl restart guruverse-worker:*`

- [ ] Monitoring queue jobs:
  - [ ] Setup logging untuk failed jobs
  - [ ] Configure alerts untuk job failures

---

## ✨ Phase 6: Testing & Validation

### Unit Testing
- [ ] Test Job `GenerateCertificate` di isolation
- [ ] Test Event `CourseCompleted` dispatch
- [ ] Test Listener execution

### Integration Testing
- [ ] Upload materi ke S3
  - [ ] Verifikasi file tersimpan di S3
  - [ ] Verifikasi path disimpan di database
  - [ ] Verifikasi video bisa diplay

- [ ] Trigger certificate generation
  - [ ] Verifikasi Job masuk ke queue
  - [ ] Verifikasi Job berjalan oleh worker
  - [ ] Verifikasi PDF ter-generate
  - [ ] Verifikasi PDF ter-upload ke S3
  - [ ] Verifikasi URL disimpan di database

- [ ] Student download sertifikat
  - [ ] Verifikasi sertifikat bisa di-download
  - [ ] Verifikasi sertifikat bisa di-view di browser
  - [ ] Verifikasi permission control (hanya siswa/admin)

### Performance Testing
- [ ] Concurrent uploads (simulasi multiple guru upload)
- [ ] Concurrent certificate generation (simulasi multiple siswa selesai course)
- [ ] Large file upload (test dengan file 50-100MB)

---

## 🔐 Phase 7: Security Verification

- [ ] `.env` file di `.gitignore`
  - [ ] Verifikasi dengan `git check-ignore .env`

- [ ] AWS credentials
  - [ ] Gunakan IAM User (bukan root)
  - [ ] IAM User punya minimal permissions (s3:GetObject, s3:PutObject, s3:DeleteObject)
  - [ ] Enable MFA untuk AWS account

- [ ] S3 Bucket security
  - [ ] Bucket tidak public accessible
  - [ ] Enable versioning (optional tapi recommended)
  - [ ] Enable encryption
  - [ ] Setup CORS jika diperlukan frontend access

- [ ] File upload validation
  - [ ] Validate file type (mp3, mp4, pdf only)
  - [ ] Validate file size (max 100MB)
  - [ ] Scan for malware (optional, tapi recommended di production)

- [ ] Database security
  - [ ] Queue table tidak exposed ke public API
  - [ ] Certificate URLs tidak dapat di-enumerate

---

## 📊 Phase 8: Monitoring & Logging

- [ ] Setup logging
  - [ ] Log successful certificate generation
  - [ ] Log failed certificate generation
  - [ ] Log S3 upload/download errors

- [ ] Setup monitoring
  - [ ] Monitor queue length: `php artisan queue:monitor`
  - [ ] Monitor failed jobs: `php artisan queue:failed`
  - [ ] Monitor S3 storage usage

- [ ] Setup alerts
  - [ ] Alert jika queue terlalu banyak
  - [ ] Alert jika job repeatedly failed
  - [ ] Alert jika S3 storage mendekati limit

---

## 🎯 Phase 9: Documentation & Training

- [ ] Create user documentation
  - [ ] Guru: Cara upload materi
  - [ ] Siswa: Cara download sertifikat
  - [ ] Admin: Cara monitor queue

- [ ] Create developer documentation
  - [ ] Setup new developer environment
  - [ ] Troubleshooting common issues
  - [ ] Architecture overview

- [ ] Training sessions
  - [ ] Train content team tentang upload materi
  - [ ] Train support team tentang troubleshooting
  - [ ] Train admin tentang monitoring

---

## 🐛 Phase 10: Troubleshooting Checklist

**Jika ada error, check list ini:**

### Certificate tidak generate
- [ ] Queue worker sedang berjalan? `ps aux | grep queue:work`
- [ ] Event di-dispatch ke listener? Check log file
- [ ] Job ada di table `jobs`? `SELECT * FROM jobs;`
- [ ] DomPDF terinstall? `composer show | grep dompdf`
- [ ] Template file ada? `resources/views/certificates/template.blade.php`

### Materi tidak ter-upload ke S3
- [ ] AWS credentials benar? Test dengan AWS CLI
- [ ] Bucket ada? `aws s3 ls`
- [ ] IAM User punya permission? Check IAM policies
- [ ] File size < 100MB? Check limit di controller
- [ ] Connection error? Check network logs

### Sertifikat tidak bisa di-download
- [ ] File ada di S3? Check di AWS Console
- [ ] URL di database benar? Check table `certificates`
- [ ] Route ter-register? `php artisan route:list | grep certificate`
- [ ] Permission check pass? Debug CertificateController
- [ ] CORS configured? Check S3 CORS settings

### Queue worker stuck
- [ ] Check log: `tail -f backend/storage/logs/laravel.log`
- [ ] Check failed jobs: `php artisan queue:failed`
- [ ] Restart worker: `killall php` then `php artisan queue:work`
- [ ] Check supervisor status: `supervisorctl status`

---

## 📝 Sign-off

- [ ] **Developer**: Implementasi selesai & tested
- [ ] **QA**: Testing selesai & semua passed
- [ ] **DevOps**: Production setup selesai
- [ ] **PM**: Feature approved & ready untuk release

---

**Notes/Issues/Comments**:
```
[Write any issues or notes here]
```

---

**Completed Date**: _______________  
**Completed By**: _______________  
**Verified By**: _______________
