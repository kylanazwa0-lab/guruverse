<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/**
 * Job untuk Generate Sertifikat PDF
 * 
 * Dijalankan di background queue untuk tidak memblok request HTTP
 * Ideal untuk proses yang memakan memori/waktu seperti generate PDF
 */
class GenerateCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Data siswa dan kursus untuk sertifikat
     */
    protected $studentId;
    protected $courseId;
    protected $studentName;
    protected $courseName;
    protected $completionDate;

    /**
     * Tentukan berapa lama job ini boleh dijalankan (dalam detik)
     * Membuat PDF bisa memakan 30-60 detik
     */
    public $timeout = 120;

    /**
     * Tentukan berapa kali retry jika gagal
     */
    public $tries = 3;

    /**
     * Jarak waktu antar retry (dalam detik)
     */
    public $backoff = [10, 60];

    /**
     * Create a new job instance.
     * 
     * @param int $studentId
     * @param int $courseId
     * @param string $studentName
     * @param string $courseName
     * @param string $completionDate Format: "03 June 2026"
     */
    public function __construct($studentId, $courseId, $studentName, $courseName, $completionDate)
    {
        $this->studentId = $studentId;
        $this->courseId = $courseId;
        $this->studentName = $studentName;
        $this->courseName = $courseName;
        $this->completionDate = $completionDate;
    }

    /**
     * Execute the job.
     * 
     * Fungsi ini berjalan di background queue worker
     */
    public function handle()
    {
        try {
            Log::info("🔄 Starting certificate generation for student {$this->studentId}");

            // 1. Generate nama file sertifikat (unik berdasarkan student & course)
            $filename = "certificate_s{$this->studentId}_c{$this->courseId}_" . time() . ".pdf";
            $filepath = "certificates/{$filename}";

            // 2. Generate PDF dari Blade template
            $pdf = Pdf::loadView('certificate.template', [
                'studentName' => $this->studentName,
                'courseName' => $this->courseName,
                'completionDate' => $this->completionDate,
            ])
            ->setPaper('a4', 'portrait')
            ->setWarnings(false);

            // 3. Simpan PDF langsung ke S3
            Storage::disk('s3')->put(
                $filepath,
                $pdf->output(),
                ['visibility' => 'public']
            );

            Log::info("✅ PDF generated and uploaded to S3: {$filepath}");

            // 4. Simpan URL sertifikat ke database
            // Uncomment dan sesuaikan dengan model Anda
            \DB::table('student_certificates')->updateOrInsert(
                [
                    'student_id' => $this->studentId,
                    'course_id' => $this->courseId,
                ],
                [
                    'certificate_url' => $filepath,
                    'certificate_filename' => $filename,
                    'generated_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            Log::info("✅ Certificate record saved to database for student {$this->studentId}");

            // 5. Optional: Kirim email notifikasi ke siswa
            // Mail::to($student->email)->send(new CertificateReady($filepath));

        } catch (\Exception $e) {
            Log::error("❌ Failed to generate certificate: " . $e->getMessage(), [
                'student_id' => $this->studentId,
                'course_id' => $this->courseId,
                'exception' => $e,
            ]);
            throw $e; // Throw untuk trigger retry
        }
    }

    /**
     * Handle a job failure setelah semua retry gagal.
     * 
     * Dipanggil oleh Laravel jika job gagal di semua attempt
     */
    public function failed(\Throwable $exception)
    {
        Log::error("❌ Certificate generation job FAILED (all retries exhausted) for student {$this->studentId}", [
            'course_id' => $this->courseId,
            'exception' => $exception->getMessage(),
        ]);

        // Optional: Simpan ke failed_certificates table atau kirim alert admin
        \DB::table('failed_certificates')->insert([
            'student_id' => $this->studentId,
            'course_id' => $this->courseId,
            'error_message' => $exception->getMessage(),
            'failed_at' => now(),
        ]);
    }
}
