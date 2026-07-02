<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Jobs\GenerateCertificate;
use App\Jobs\GenerateCertificateJob;

class MateriController extends Controller
{
    /**
     * Upload materi pembelajaran (MP3, MP4, PDF) ke Cloud Storage (S3)
     */
    public function uploadMateri(Request $request)
    {
        // 1. Validasi input file
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_materi' => 'required|mimes:mp3,mp4,pdf|max:102400', // Batas 100MB
            'course_id' => 'required|integer',
        ]);

        try {
            // 2. Upload file langsung ke Cloud Storage (S3) ke dalam folder 'materi'
            $file = $request->file('file_materi');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            
            // Generate nama file unik
            $filename = time() . '-' . uniqid() . '.' . $extension;
            $path = $file->storeAs('materi', $filename, 's3');

            // 3. Simpan path/URL ke database utama
            // Contoh: Materi::create([
            //     'judul' => $validated['judul'],
            //     'deskripsi' => $validated['deskripsi'],
            //     'tipe' => $extension,
            //     'file_url' => $path, // Hasilnya: "materi/1234567890-abc123def.mp4"
            //     'course_id' => $validated['course_id'],
            //     'uploaded_by' => auth()->id(),
            // ]);

            return back()->with('success', 'Materi berhasil diunggah! File disimpan di Cloud Storage.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengunggah materi: ' . $e->getMessage());
        }
    }

    /**
     * Download materi dari Cloud Storage
     */
    public function downloadMateri($fileUrl)
    {
        try {
            if (!Storage::disk('s3')->exists($fileUrl)) {
                return back()->with('error', 'File tidak ditemukan.');
            }

            return Storage::disk('s3')->download($fileUrl);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mendownload file: ' . $e->getMessage());
        }
    }

    /**
     * Delete materi dari Cloud Storage
     */
    public function deleteMateri($fileUrl)
    {
        try {
            if (Storage::disk('s3')->exists($fileUrl)) {
                Storage::disk('s3')->delete($fileUrl);
            }

            return back()->with('success', 'Materi berhasil dihapus.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus materi: ' . $e->getMessage());
        }
    }

    /**
     * Tandai siswa telah menyelesaikan kursus
     * Trigger Job untuk generate sertifikat PDF
     */
    public function markCourseComplete(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer',
            'course_id' => 'required|integer',
        ]);

        try {
            // Tandai selesai di database
            \DB::table('course_completions')->updateOrInsert(
                [
                    'student_id' => $validated['student_id'],
                    'course_id' => $validated['course_id'],
                ],
                [
                    'completed_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Ambil data siswa dan kursus
            $student = \DB::table('students')->find($validated['student_id']);
            $course = \DB::table('courses')->find($validated['course_id']);

            if ($student && $course) {
                // ⭐ MASUKKAN JOB UNTUK GENERATE SERTIFIKAT KE QUEUE
                // Job ini akan berjalan di background, tidak memblock request HTTP
                GenerateCertificateJob::dispatch(
                    $validated['student_id'],
                    $validated['course_id'],
                    $student->nama ?? $student->name,
                    $course->nama ?? $course->name,
                    now()->format('d F Y')
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Kursus ditandai selesai. Sertifikat sedang diproses di latar belakang...',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Data siswa atau kursus tidak ditemukan.',
            ], 404);

        } catch (\Exception $e) {
            \Log::error("Mark course complete failed: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ambil URL file dari S3 untuk diputar di browser
     */
    public function getMediaUrl($fileUrl)
    {
        try {
            $url = Storage::disk('s3')->url($fileUrl);
            return response()->json([
                'success' => true,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil URL media: ' . $e->getMessage(),
            ], 500);
        }
    }
}
