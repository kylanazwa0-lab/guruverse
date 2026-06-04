@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>{{ $materi->judul ?? 'Media Player' }}</h2>
            <p class="text-muted">{{ $materi->deskripsi ?? '' }}</p>

            <!-- Media Player Container -->
            <div class="media-player-container mb-4" style="background: #000; border-radius: 8px; overflow: hidden;">
                @php
                    $fileType = pathinfo($materi->file_url, PATHINFO_EXTENSION) ?? 'mp4';
                    $mediaUrl = \Storage::disk('s3')->url($materi->file_url);
                @endphp

                @if(in_array($fileType, ['mp4', 'avi', 'mov', 'mkv']))
                    <!-- VIDEO PLAYER -->
                    <video width="100%" height="600" controls style="background: #000;">
                        <source src="{{ $mediaUrl }}" type="video/{{ $fileType === 'mkv' ? 'quicktime' : $fileType }}">
                        Browser Anda tidak mendukung pemutar video.
                    </video>

                @elseif(in_array($fileType, ['mp3', 'wav', 'aac', 'flac']))
                    <!-- AUDIO PLAYER -->
                    <div class="audio-player-wrapper d-flex align-items-center justify-content-center" style="height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="text-center text-white">
                            <i class="fas fa-music" style="font-size: 80px; margin-bottom: 20px;"></i>
                            <h4>{{ $materi->judul }}</h4>
                        </div>
                    </div>
                    <audio width="100%" controls style="width: 100%; margin-top: 20px;">
                        <source src="{{ $mediaUrl }}" type="audio/{{ $fileType }}">
                        Browser Anda tidak mendukung pemutar audio.
                    </audio>

                @elseif(in_array($fileType, ['pdf']))
                    <!-- PDF VIEWER -->
                    <div class="pdf-viewer">
                        <iframe src="{{ $mediaUrl }}#toolbar=0" width="100%" height="700" style="border: none;"></iframe>
                    </div>

                @else
                    <!-- UNSUPPORTED FORMAT -->
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Format file tidak didukung untuk preview. 
                        <a href="{{ route('materi.download', $materi->id) }}" class="btn btn-sm btn-primary">
                            Download File
                        </a>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('courses.show', $materi->course_id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Kursus
                </a>
                <a href="{{ route('materi.download', $materi->id) }}" class="btn btn-success">
                    <i class="fas fa-download"></i> Download
                </a>
                <button class="btn btn-info" onclick="markAsWatched()">
                    <i class="fas fa-check"></i> Tandai Selesai
                </button>
            </div>

            <!-- Media Information -->
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Media</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tipe File:</strong> {{ strtoupper($fileType) }}</p>
                            <p><strong>Ukuran:</strong> {{ formatBytes($materi->file_size ?? 0) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Diunggah:</strong> {{ $materi->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Pengajar:</strong> {{ $materi->teacher->name ?? 'Unknown' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Tracking (Optional) -->
            @if(auth()->check())
            <div class="card mt-4">
                <div class="card-body">
                    <h5>Progress Anda</h5>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{ auth()->user()->progress ?? 0 }}%;" 
                             aria-valuenow="{{ auth()->user()->progress ?? 0 }}" 
                             aria-valuemin="0" aria-valuemax="100">
                            {{ auth()->user()->progress ?? 0 }}%
                        </div>
                    </div>
                    <p class="text-muted mt-2">Selesaikan semua materi untuk mendapatkan sertifikat.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Script untuk tandai selesai -->
<script>
function markAsWatched() {
    const courseId = {{ $materi->course_id ?? 0 }};
    const studentId = {{ auth()->user()->id ?? 0 }};

    if (!studentId) {
        alert('Anda harus login terlebih dahulu.');
        return;
    }

    fetch('{{ route("materi.mark-complete") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            student_id: studentId,
            course_id: courseId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            // Refresh halaman atau update progress bar
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}
</script>

<style>
    .media-player-container {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .audio-player-wrapper {
        border-radius: 8px;
    }
    
    .gap-2 {
        gap: 10px;
    }
</style>
@endsection

@php
    /**
     * Helper function untuk format bytes
     */
    if (!function_exists('formatBytes')) {
        function formatBytes($bytes, $precision = 2) {
            $units = ['B', 'KB', 'MB', 'GB'];
            $bytes = max($bytes, 0);
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $bytes /= (1 << (10 * $pow));
            return round($bytes, $precision) . ' ' . $units[$pow];
        }
    }
@endphp
