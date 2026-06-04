<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class GenerateCertificate implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $studentId;
    protected $courseId;
    protected $studentName;
    protected $courseName;
    protected $completionDate;

    /**
     * Create a new job instance.
     */
    public function __construct($studentId, $courseId, $studentName, $courseName, $completionDate = null)
    {
        $this->studentId = $studentId;
        $this->courseId = $courseId;
        $this->studentName = $studentName;
        $this->courseName = $courseName;
        $this->completionDate = $completionDate ?? now()->format('d-m-Y');
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            // 1. Persiapan data sertifikat
            $data = [
                'student_name' => $this->studentName,
                'course_name' => $this->courseName,
                'completion_date' => $this->completionDate,
                'certificate_number' => 'CERT-' . $this->studentId . '-' . $this->courseId . '-' . time(),
            ];

            // 2. Generate PDF dari template blade
            $pdf = Pdf::loadView('certificates.template', $data);

            // 3. Simpan PDF ke Cloud Storage (S3)
            $filename = "certificates/student-{$this->studentId}-course-{$this->courseId}.pdf";
            $pdfContent = $pdf->stream();
            
            Storage::disk('s3')->put($filename, $pdfContent->getOriginalContent());

            // 4. Simpan informasi sertifikat ke database (opsional)
            // \App\Models\Certificate::create([
            //     'student_id' => $this->studentId,
            //     'course_id' => $this->courseId,
            //     'file_url' => $filename,
            //     'certificate_number' => $data['certificate_number'],
            //     'issued_at' => now(),
            // ]);

            // 5. Log sukses
            \Log::info("Certificate generated successfully for student {$this->studentId}");

        } catch (\Exception $e) {
            \Log::error("Error generating certificate: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        \Log::error("Certificate job failed: {$exception->getMessage()}");
    }
}
