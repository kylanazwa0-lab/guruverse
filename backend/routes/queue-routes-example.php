<?php

/**
 * CONTOH ROUTES UNTUK MATERI & CERTIFICATE
 * 
 * File ini adalah contoh. Salin dan integrasikan ke routes/web.php atau routes/api.php
 */

use App\Http\Controllers\MateriController;
use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;

// ============================================================================
// ROUTE UNTUK MATERI (Upload, Download, Delete)
// ============================================================================

Route::middleware(['auth'])->group(function () {
    // Upload Materi
    Route::post('/materi/upload', [MateriController::class, 'uploadMateri'])
        ->name('materi.upload');

    // Download Materi
    Route::get('/materi/{id}/download', [MateriController::class, 'downloadMateri'])
        ->name('materi.download');

    // Delete Materi (Guru only)
    Route::delete('/materi/{id}', [MateriController::class, 'deleteMateri'])
        ->name('materi.delete')
        ->middleware('role:guru');
});

// ============================================================================
// ROUTE UNTUK CERTIFICATE (Download, View)
// ============================================================================

Route::middleware(['auth'])->group(function () {
    // List Certificate untuk User
    Route::get('/certificates', [CertificateController::class, 'index'])
        ->name('certificates.index');

    // View Certificate PDF
    Route::get('/certificates/{id}', [CertificateController::class, 'show'])
        ->name('certificates.show');

    // Download Certificate PDF
    Route::get('/certificates/{id}/download', [CertificateController::class, 'download'])
        ->name('certificates.download');
});

// ============================================================================
// CONTOH FORM UPLOAD MATERI (Blade Template)
// ============================================================================

/*
<form action="{{ route('materi.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="judul">Judul Materi</label>
        <input type="text" name="judul" id="judul" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi (Opsional)</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
    </div>

    <div class="form-group">
        <label for="course_id">Pilih Course</label>
        <select name="course_id" id="course_id" class="form-control" required>
            <option value="">-- Pilih Course --</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="file_materi">Upload File (MP3, MP4, PDF - Max 100MB)</label>
        <input type="file" name="file_materi" id="file_materi" 
               accept=".mp3,.mp4,.pdf" 
               class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Upload Materi</button>
</form>
*/

// ============================================================================
// CONTOH MENAMPILKAN VIDEO DI BLADE
// ============================================================================

/*
@if($materi->tipe === 'mp4')
    <video width="100%" controls style="max-height: 600px;">
        <source src="{{ Storage::disk('s3')->url($materi->file_url) }}" type="video/mp4">
        Browser Anda tidak mendukung pemutar video.
    </video>
@elseif($materi->tipe === 'mp3')
    <audio controls style="width: 100%;">
        <source src="{{ Storage::disk('s3')->url($materi->file_url) }}" type="audio/mpeg">
        Browser Anda tidak mendukung pemutar audio.
    </audio>
@elseif($materi->tipe === 'pdf')
    <iframe src="{{ Storage::disk('s3')->url($materi->file_url) }}" 
            width="100%" height="600px"></iframe>
@endif
*/

// ============================================================================
// CONTOH MENAMPILKAN LIST SERTIFIKAT SISWA
// ============================================================================

/*
<h2>Sertifikat Saya</h2>

@if($certificates->count() > 0)
    <div class="row">
        @foreach($certificates as $cert)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $cert->course->name }}</h5>
                        <p class="card-text">
                            <small>Dikeluarkan: {{ $cert->issued_at->format('d M Y') }}</small>
                        </p>
                        <a href="{{ route('certificates.download', $cert->id) }}" 
                           class="btn btn-sm btn-primary">
                            Download Sertifikat
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>Anda belum memiliki sertifikat. Selesaikan course untuk mendapatkannya!</p>
@endif
*/
