<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class CertificateController extends Controller
{
    /**
     * List all certificates for authenticated user
     */
    public function index()
    {
        $certificates = Certificate::where('student_id', auth()->id())
            ->with('course')
            ->latest('issued_at')
            ->paginate(10);

        return view('certificates.index', compact('certificates'));
    }

    /**
     * Show/Display certificate PDF in browser
     */
    public function show($id)
    {
        $certificate = Certificate::findOrFail($id);

        // Authorization check
        if ($certificate->student_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke sertifikat ini.');
        }

        // Get file from S3
        $file = Storage::disk('s3')->get($certificate->file_url);

        return response($file)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="sertifikat.pdf"');
    }

    /**
     * Download certificate PDF
     */
    public function download($id)
    {
        $certificate = Certificate::findOrFail($id);

        // Authorization check
        if ($certificate->student_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke sertifikat ini.');
        }

        return Storage::disk('s3')->download(
            $certificate->file_url,
            "sertifikat-{$certificate->certificate_number}.pdf"
        );
    }
}
