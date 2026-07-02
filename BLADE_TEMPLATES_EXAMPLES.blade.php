{{-- 
  CONTOH BLADE TEMPLATES UNTUK FITUR MATERI & SERTIFIKAT
  Salin dan sesuaikan dengan design Guruverse Anda
--}}

{{-- ===================================================================== --}}
{{-- FILE: resources/views/materi/upload-form.blade.php --}}
{{-- ===================================================================== --}}

@extends('layouts.app')

@section('title', 'Upload Materi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Upload Materi Pembelajaran</h5>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('materi.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Materi <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="judul" 
                                   id="judul" 
                                   class="form-control @error('judul') is-invalid @enderror"
                                   placeholder="Contoh: Pengenalan PHP OOP"
                                   value="{{ old('judul') }}"
                                   required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" 
                                      id="deskripsi" 
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Jelaskan singkat tentang materi ini...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="course_id" class="form-label">Pilih Course <span class="text-danger">*</span></label>
                            <select name="course_id" 
                                    id="course_id" 
                                    class="form-select @error('course_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" 
                                            @selected(old('course_id') == $course->id)>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="file_materi" class="form-label">Upload File <span class="text-danger">*</span></label>
                            <div class="alert alert-info">
                                <small>
                                    <strong>Format didukung:</strong> MP3, MP4, PDF<br>
                                    <strong>Ukuran maksimal:</strong> 100 MB
                                </small>
                            </div>
                            <input type="file" 
                                   name="file_materi" 
                                   id="file_materi" 
                                   class="form-control @error('file_materi') is-invalid @enderror"
                                   accept=".mp3,.mp4,.pdf"
                                   required>
                            @error('file_materi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-cloud-upload"></i> Upload Materi
                            </button>
                            <a href="{{ route('courses.show', $course_id ?? '') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


{{-- ===================================================================== --}}
{{-- FILE: resources/views/materi/display.blade.php --}}
{{-- ===================================================================== --}}

@extends('layouts.app')

@section('title', $materi->judul)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="mb-0">{{ $materi->judul }}</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ $materi->deskripsi }}</p>

                    {{-- Video Player --}}
                    @if($materi->tipe === 'mp4')
                        <div class="video-container mb-3">
                            <video width="100%" height="500" controls style="background: #000; border-radius: 8px;">
                                <source src="{{ Storage::disk('s3')->url($materi->file_url) }}" type="video/mp4">
                                <p>Browser Anda tidak mendukung pemutar video HTML5.</p>
                            </video>
                        </div>
                    @endif

                    {{-- Audio Player --}}
                    @if($materi->tipe === 'mp3')
                        <div class="audio-container mb-3">
                            <audio controls style="width: 100%; height: 40px; border-radius: 8px;">
                                <source src="{{ Storage::disk('s3')->url($materi->file_url) }}" type="audio/mpeg">
                                <p>Browser Anda tidak mendukung pemutar audio.</p>
                            </audio>
                        </div>
                    @endif

                    {{-- PDF Viewer --}}
                    @if($materi->tipe === 'pdf')
                        <div class="pdf-container mb-3">
                            <iframe src="{{ Storage::disk('s3')->url($materi->file_url) }}" 
                                    width="100%" 
                                    height="600px"
                                    style="border: 1px solid #ddd; border-radius: 8px;">
                            </iframe>
                        </div>
                        <a href="{{ Storage::disk('s3')->url($materi->file_url) }}" 
                           download class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download"></i> Download PDF
                        </a>
                    @endif
                </div>
            </div>

            {{-- Materi Details --}}
            <div class="card">
                <div class="card-body">
                    <p><strong>Diupload oleh:</strong> {{ $materi->uploadedBy->name }}</p>
                    <p><strong>Tanggal Upload:</strong> {{ $materi->created_at->format('d M Y H:i') }}</p>
                    @if($materi->durasi)
                        <p><strong>Durasi:</strong> {{ floor($materi->durasi / 60) }}:{{ str_pad($materi->durasi % 60, 2, '0', STR_PAD_LEFT) }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- Sidebar --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Course</h5>
                </div>
                <div class="card-body">
                    <h6>{{ $materi->course->name }}</h6>
                    <p class="text-muted small">{{ $materi->course->description ?? 'Tidak ada deskripsi' }}</p>
                    <a href="{{ route('courses.show', $materi->course_id) }}" class="btn btn-sm btn-primary">
                        Lihat Course
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


{{-- ===================================================================== --}}
{{-- FILE: resources/views/certificates/index.blade.php --}}
{{-- ===================================================================== --}}

@extends('layouts.app')

@section('title', 'Sertifikat Saya')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="bi bi-award"></i> Sertifikat Saya
            </h2>

            @if($certificates->count() > 0)
                <div class="row">
                    @foreach($certificates as $cert)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <i class="bi bi-award" style="font-size: 2.5rem; color: #FFD700;"></i>
                                    </div>

                                    <h5 class="card-title">{{ $cert->course->name }}</h5>

                                    <p class="card-text text-muted">
                                        <small>
                                            <strong>Tanggal Lulus:</strong><br>
                                            {{ $cert->issued_at->format('d M Y') }}
                                        </small>
                                    </p>

                                    <p class="card-text text-muted">
                                        <small>
                                            <strong>Nomor:</strong><br>
                                            <code>{{ $cert->certificate_number }}</code>
                                        </small>
                                    </p>

                                    <div class="d-grid gap-2">
                                        <a href="{{ route('certificates.show', $cert->id) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           target="_blank">
                                            <i class="bi bi-eye"></i> Lihat Sertifikat
                                        </a>
                                        <a href="{{ route('certificates.download', $cert->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $certificates->links() }}
                </div>

            @else
                <div class="alert alert-info text-center" role="alert">
                    <h5><i class="bi bi-info-circle"></i> Belum Ada Sertifikat</h5>
                    <p class="mb-0">Selesaikan course untuk mendapatkan sertifikat resmi dari Guruverse!</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-primary mt-3">
                        Lihat Course Tersedia
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: box-shadow 0.3s ease;
    }
    
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.3) !important;
    }
</style>
@endsection


{{-- ===================================================================== --}}
{{-- CUSTOM CSS (tambahkan ke assets/css/app.css) --}}
{{-- ===================================================================== --}}

/*
.video-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
}

.video-container video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.audio-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
    border-radius: 8px;
}

.audio-container audio {
    filter: brightness(0) invert(1);
}

code {
    background-color: #f8f9fa;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    color: #e83e8c;
    font-size: 0.875rem;
}
*/
