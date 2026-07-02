<?php

namespace App\Listeners;

use App\Events\CourseCompleted;
use App\Jobs\GenerateCertificate;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCertificateOnCompletion implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * Ketika siswa menyelesaikan kursus, dispatch Job untuk membuat sertifikat di background
     */
    public function handle(CourseCompleted $event): void
    {
        // Dispatch Job ke queue untuk membuat sertifikat secara async
        GenerateCertificate::dispatch(
            $event->studentId,
            $event->courseId,
            $event->studentName,
            $event->courseName
        );
    }
}
