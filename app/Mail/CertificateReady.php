<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email notification ketika sertifikat sudah selesai digenerate
 * 
 * Gunakan di GenerateCertificateJob untuk kirim email ke siswa
 */
class CertificateReady extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $certificateUrl;
    public $studentName;
    public $courseName;

    /**
     * Create a new message instance.
     */
    public function __construct($certificateUrl, $studentName, $courseName)
    {
        $this->certificateUrl = $certificateUrl;
        $this->studentName = $studentName;
        $this->courseName = $courseName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "🎉 Sertifikat Anda Siap! - {$this->courseName}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.certificate-ready',
            with: [
                'studentName' => $this->studentName,
                'courseName' => $this->courseName,
                'certificateUrl' => $this->certificateUrl,
                'downloadLink' => route('certificate.download', ['url' => urlencode($this->certificateUrl)]),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
