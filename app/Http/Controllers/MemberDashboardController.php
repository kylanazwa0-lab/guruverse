<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Certificate;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberDashboardController extends Controller
{
    /**
     * Tampilkan halaman portal utama untuk member.
     */
    public function portal()
    {
        $member = Auth::guard('web')->user();
        return view('member.portal', compact('member'));
    }

    public function profilPortal()
    {
        $member = Auth::guard('web')->user();
        return view('member.profil_portal', compact('member'));
    }

    /**
     * Ambil statistik member dari DB dan tampilkan dashboard.
     */
    public function index()
    {
        $member = Auth::guard('web')->user();

        $stats = $this->getMemberStats($member->id);

        // Fetch latest active enrollment via Eloquent (Contoh Refaktor)
        $latest_enrollment = Enrollment::with('course')
            ->where('user_id', $member->id)
            ->where('status', '!=', 'completed')
            ->orderBy('enrolled_at', 'desc')
            ->first();

        $latest_enrollment_arr = null;
        if ($latest_enrollment && $latest_enrollment->course) {
            $latest_enrollment_arr = [
                'id' => $latest_enrollment->id,
                'course_id' => $latest_enrollment->course_id,
                'completed_modules' => $latest_enrollment->completed_modules ?? 0,
                'status' => $latest_enrollment->status,
                'title' => $latest_enrollment->course->title,
                'total_modules' => $latest_enrollment->course->modules()->count(),
            ];
        }

        // --- Refactor: Rekomendasi ---
        $rekomendasi = [];
        $rekomendasi_enrolled = false;

        $courses_not_enrolled = Course::whereDoesntHave('enrollments', function($q) use ($member) {
                $q->where('user_id', $member->id);
            })
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        if ($courses_not_enrolled->isNotEmpty()) {
            $rekomendasi = $courses_not_enrolled->map(function($c) {
                return [
                    'id' => $c->id, 'title' => $c->title, 'category' => $c->category,
                    'duration_hours' => $c->duration_hours, 'total_modules' => $c->modules()->count(),
                    'is_free' => 1, 'rating' => 4.5, 'thumbnail' => $c->thumbnail,
                    'is_enrolled' => 0, 'enroll_status' => null, 'pdf_path' => null, 'completed_modules' => 0
                ];
            })->toArray();
        } else {
            $rekomendasi_enrolled = true;
            $active_enrollments = Enrollment::with('course')
                ->where('user_id', $member->id)
                ->where('status', '!=', 'completed')
                ->whereHas('course', function($q) { $q->where('is_active', true); })
                ->orderBy('enrolled_at', 'desc')
                ->limit(3)
                ->get();

            if ($active_enrollments->isNotEmpty()) {
                $rekomendasi = $active_enrollments->map(function($e) use ($member) {
                    $cert = \Illuminate\Support\Facades\DB::table('gb_certificates')->where('course_id', $e->course_id)->where('user_id', $member->id)->first();
                    return [
                        'id' => $e->course->id, 'title' => $e->course->title, 'category' => $e->course->category,
                        'duration_hours' => $e->course->duration_hours, 'total_modules' => $e->course->modules()->count(),
                        'is_free' => 1, 'rating' => 4.5, 'thumbnail' => $e->course->thumbnail,
                        'is_enrolled' => 1, 'enroll_status' => $e->status, 'completed_modules' => $e->completed_modules ?? 0,
                        'pdf_path' => null
                    ];
                })->toArray();
            } else {
                $completed_enrollments = Enrollment::with('course')
                    ->where('user_id', $member->id)
                    ->where('status', 'completed')
                    ->whereHas('course', function($q) { $q->where('is_active', true); })
                    ->orderBy('enrolled_at', 'desc')
                    ->limit(3)
                    ->get();
                    
                if ($completed_enrollments->isNotEmpty()) {
                    $rekomendasi = $completed_enrollments->map(function($e) use ($member) {
                        $cert = \Illuminate\Support\Facades\DB::table('gb_certificates')->where('course_id', $e->course_id)->where('user_id', $member->id)->first();
                        return [
                            'id' => $e->course->id, 'title' => $e->course->title, 'category' => $e->course->category,
                            'duration_hours' => $e->course->duration_hours, 'total_modules' => $e->course->modules()->count(),
                            'is_free' => 1, 'rating' => 4.5, 'thumbnail' => $e->course->thumbnail,
                            'is_enrolled' => 1, 'enroll_status' => $e->status, 'completed_modules' => $e->completed_modules ?? 0,
                            'pdf_path' => $cert ? $cert->pdf_path : null
                        ];
                    })->toArray();
                }
            }
        }

        // --- Refactor: Populer ---
        $populer = Course::withCount('enrollments')
            ->where('is_active', true)
            ->orderByDesc('enrollments_count')
            ->limit(3)
            ->get()
            ->map(function($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'category' => $course->category,
                    'duration_hours' => $course->duration_hours,
                    'total_modules' => $course->modules()->count(),
                    'is_free' => 1,
                    'rating' => 4.5,
                    'thumbnail' => $course->thumbnail,
                    'enroll_count' => $course->enrollments_count
                ];
            })->toArray();


        return view('member.dashboard', [
            'member'            => $member,
            'total_kelas'       => $stats['total_kelas'],
            'kelas_selesai'     => $stats['kelas_selesai'],
            'total_sertifikat'  => $stats['total_sertifikat'],
            'total_jam'         => $stats['total_jam'],
            'notifications'     => $this->getNotifications($member->id),
            'unread_notif'      => $stats['unread_notif'],
            'latest_enrollment' => $latest_enrollment_arr,
            'rekomendasi'       => $rekomendasi,
            'rekomendasi_enrolled' => $rekomendasi_enrolled,
            'populer'           => $populer,
        ]);
    }

    public function kelas()
    {
        $member = Auth::guard('web')->user();
        $enrollments = Enrollment::with('course')
            ->where('user_id', $member->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('member.kelas', compact('member', 'enrollments'));
    }

    public function modul(Request $request)
    {
        $member = Auth::guard('web')->user();
        $courseId = $request->query('course_id');
        $modules = [];
        $course = null;

        if ($courseId) {
            $course = Course::find($courseId);
            if ($course) {
                $modules = $course->modules()->orderBy('order')->get();
            }
        }

        return view('member.modul', compact('member', 'course', 'modules'));
    }

    public function sertifikat()
    {
        $member = Auth::guard('web')->user();
        $certificates = Certificate::where('user_id', $member->id)
            ->with('course')
            ->orderBy('issued_at', 'desc')
            ->get();

        return view('member.sertifikat', compact('member', 'certificates'));
    }

    public function diskusi()
    {
        $member = Auth::guard('web')->user();
        return view('member.diskusi', compact('member'));
    }

    public function pengaturan()
    {
        $member = Auth::guard('web')->user();
        $parts = explode(' ', $member->full_name ?? 'Member');
        $user_initials = strtoupper(substr($parts[0] ?? 'M', 0, 1));
        if (count($parts) > 1) {
            $user_initials .= strtoupper(substr($parts[1], 0, 1));
        }

        $stats = $this->getMemberStats($member->id);

        return view('member.pengaturan', [
            'member' => $member,
            'user' => [
                'email' => $member->email,
                'phone' => $member->phone,
                'city'  => $member->city,
                'institution' => $member->institution,
                'subject' => $member->subject,
                'created_at' => $member->created_at,
            ],
            'user_name' => $member->full_name,
            'user_initials' => $user_initials,
            'total_kelas' => $stats['total_kelas'],
            'total_sertifikat' => $stats['total_sertifikat'],
        ]);
    }

    public function updateProfile(Request $request)
    {
        $member = Auth::guard('web')->user();

        $request->validate([
            'full_name'   => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'photo'       => 'nullable|image|max:2048',
        ]);

        $data = [
            'full_name'   => $request->full_name,
            'institution' => $request->institution,
            'phone'       => $request->phone,
        ];

        if ($request->hasFile('photo')) {
            $data['photo_base64'] = base64_encode(
                file_get_contents($request->file('photo')->getRealPath())
            );
        }

        if ($request->filled('new_password')) {
            $request->validate([
                'current_password' => 'required',
                'new_password'     => 'required|min:8|confirmed',
            ]);
            if (!Hash::check($request->current_password, $member->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi lama tidak sesuai.']);
            }
            $data['password'] = Hash::make($request->new_password);
        }

        $member->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // ── API-like JSON responses (AJAX from views) ─────────────────────────────

    public function getNotificationsJson()
    {
        $member = Auth::guard('web')->user();
        $notifications = $this->getNotifications($member->id);
        return response()->json($notifications);
    }

    public function markNotificationRead(Request $request)
    {
        $member = Auth::guard('web')->user();
        $id = $request->input('id');

        Notification::where('user_id', $member->id)
            ->where('id', $id)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function getMemberStats(int $userId): array
    {
        $totalKelas     = Enrollment::where('user_id', $userId)->count();
        $kelasSelesai   = Enrollment::where('user_id', $userId)->where('status', 'completed')->count();
        $totalSertif    = Certificate::where('user_id', $userId)->count();
        $totalJam       = Enrollment::where('user_id', $userId)
                            ->join('gb_courses', 'gb_enrollments.course_id', '=', 'gb_courses.id')
                            ->sum('gb_courses.duration_hours');
        $unreadNotif    = Notification::where('user_id', $userId)->where('is_read', 0)->count();

        return compact('totalKelas', 'kelasSelesai', 'totalSertif', 'totalJam', 'unreadNotif') + [
            'total_kelas'      => $totalKelas,
            'kelas_selesai'    => $kelasSelesai,
            'total_sertifikat' => $totalSertif,
            'total_jam'        => $totalJam,
            'unread_notif'     => $unreadNotif,
        ];
    }

    private function getNotifications(int $userId): array
    {
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }
}
