<?php

/**
 * CONTOH ROUTES UNTUK MATERI & QUEUE
 * 
 * Tambahkan routes ini ke routes/web.php atau routes/api.php
 * Sesuaikan dengan struktur authentication dan prefix routing Anda
 */

// ============================================
// ROUTES UNTUK MATERI PEMBELAJARAN
// ============================================

use App\Http\Controllers\MateriController;
use Illuminate\Support\Facades\Route;

// Untuk Student/Siswa
Route::middleware(['auth:sanctum', 'role:student'])->group(function () {
    
    // Tampilkan materi (player)
    Route::get('/materi/{id}', [MateriController::class, 'show'])
        ->name('materi.show');
    
    // Download materi
    Route::get('/materi/{id}/download', [MateriController::class, 'downloadMateri'])
        ->name('materi.download');
    
    // Tandai materi selesai ditonton (TRIGGER CERTIFICATE JOB)
    Route::post('/materi/mark-complete', [MateriController::class, 'markCourseComplete'])
        ->name('materi.mark-complete');
    
    // Get media URL dari S3
    Route::get('/media-url/{fileUrl}', [MateriController::class, 'getMediaUrl'])
        ->name('media.url');
    
});

// Untuk Guru
Route::middleware(['auth:sanctum', 'role:teacher'])->group(function () {
    
    // Upload materi baru
    Route::post('/materi/upload', [MateriController::class, 'uploadMateri'])
        ->name('materi.upload');
    
    // Delete materi
    Route::delete('/materi/{id}', [MateriController::class, 'deleteMateri'])
        ->name('materi.delete');
    
});

// ============================================
// CONTOH IMPLEMENTASI DI CONTROLLER
// ============================================

/**
 * CONTOH 1: Ketika Siswa Menonton Video Sampai Selesai
 * 
 * // di student dashboard
 * <script>
 * document.getElementById('videoPlayer').addEventListener('ended', () => {
 *     fetch('/api/materi/mark-complete', {
 *         method: 'POST',
 *         headers: { 'X-CSRF-TOKEN': token },
 *         body: JSON.stringify({
 *             student_id: studentId,
 *             course_id: courseId
 *         })
 *     }).then(r => r.json()).then(data => {
 *         alert(data.message); // Sertifikat sedang diproses...
 *     });
 * });
 * </script>
 */

/**
 * CONTOH 2: Ketika Siswa Lulus Ujian Akhir
 * 
 * // di ExamController@submit
 * if ($exam->score >= $exam->passing_score) {
 *     // Siswa LULUS → Trigger certificate generation
 *     \App\Jobs\GenerateCertificateJob::dispatch(
 *         auth()->id(),
 *         $exam->course_id,
 *         auth()->user()->name,
 *         $exam->course->name,
 *         now()->format('d F Y')
 *     );
 * }
 */

/**
 * CONTOH 3: Upload Materi dari Admin Panel
 * 
 * // Form HTML
 * <form action="{{ route('materi.upload') }}" method="POST" enctype="multipart/form-data">
 *     @csrf
 *     <input type="text" name="judul" placeholder="Judul Materi" required>
 *     <textarea name="deskripsi"></textarea>
 *     <input type="file" name="file_materi" accept="audio/*,video/*,.pdf" required>
 *     <input type="hidden" name="course_id" value="{{ $course->id }}">
 *     <button type="submit" class="btn btn-primary">
 *         <i class="fas fa-cloud-upload-alt"></i> Upload ke Cloud
 *     </button>
 * </form>
 */

/**
 * CONTOH 4: Queue Management Commands
 * 
 * # Jalankan queue worker (WAJIB dijalankan!)
 * php artisan queue:work database
 * 
 * # Lihat status queue
 * php artisan queue:count
 * 
 * # Lihat failed jobs
 * php artisan queue:failed
 * 
 * # Retry specific failed job
 * php artisan queue:retry 1
 * 
 * # Retry semua failed jobs
 * php artisan queue:retry all
 * 
 * # Flush semua pending jobs
 * php artisan queue:flush
 * 
 * # Lihat queue dengan verbose output
 * php artisan queue:work database --verbose
 */
