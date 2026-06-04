<?php

namespace App\Http\Controllers\Api;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

/**
 * ============================================================================
 * API Controller: MemberController
 * ============================================================================
 * Endpoint prioritas:
 *  1. POST   /api/register       — Pendaftaran anggota baru
 *  2. POST   /api/login          — Login (username + password)
 *  3. GET    /api/members        — Ambil semua anggota (admin only)
 *  4. PUT    /api/members/{id}   — Update anggota (admin only)
 *  5. DELETE /api/members/{id}   — Hapus anggota (admin only)
 *
 * Auth: Sanctum (token-based untuk admin ops)
 * ============================================================================
 */
class MemberController extends Controller
{
    /**
     * 1️⃣  POST /api/register
     * Pendaftaran anggota baru tanpa autentikasi.
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'full_name'    => ['required', 'string', 'min:3', 'max:150'],
            'username'     => ['required', 'string', 'min:3', 'max:50', 'unique:members,username', 'regex:/^[a-zA-Z0-9_]+$/'],
            'institution'  => ['required', 'string', 'min:3', 'max:150'],
            'password'     => ['required', 'string', 'min:6', 'max:255'],
            'phone'        => ['nullable', 'string', 'regex:/^(0|62)[0-9]{9,13}$/'],
            'photo_base64' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $memberId = Member::generateMemberId();

            $member = Member::create([
                'member_id'    => $memberId,
                'full_name'    => $request->full_name,
                'username'     => $request->username,
                'institution'  => $request->institution,
                'password'     => Hash::make($request->password),
                'phone'        => $request->phone,
                'photo_base64' => $request->photo_base64,
            ]);

            return response()->json([
                'success'   => true,
                'member'    => $member->toArray(),
                'member_id' => $memberId,
                'message'   => 'Pendaftaran berhasil.',
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 2️⃣  POST /api/login
     * Login dengan username + password → Sanctum token.
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $member = Member::where('username', $request->username)->first();

        if (!$member || !Hash::check($request->password, $member->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah.',
            ], 401);
        }

        // Generate token Sanctum
        $token = $member->createToken('api_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'member'  => $member->toArray(),
            'token'   => $token,
            'message' => 'Login berhasil.',
        ], 200);
    }

    /**
     * 3️⃣  GET /api/members
     * Ambil semua data anggota (pagination + search + stats).
     * ✅ OPTIMIZED: Single query for stats using SQL aggregation (was 3 queries)
     */
    public function getMembers(Request $request): JsonResponse
    {
        $perPage = min($request->get('per_page', 15), 100);
        $search  = $request->get('search', '');

        $query = Member::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                  ->orWhere('username', 'like', "%$search%")
                  ->orWhere('institution', 'like', "%$search%");
            });
        }

        $members = $query->orderBy('id', 'desc')->paginate($perPage);

        // ✅ OPTIMIZED: Get all stats in ONE query instead of 3 separate COUNT queries
        $now = now();
        $statsRaw = \DB::selectOne("
            SELECT 
                COUNT(*) as total_members,
                SUM(CASE WHEN DATE(joined_at) = ? THEN 1 ELSE 0 END) as today_registered,
                SUM(CASE WHEN MONTH(joined_at) = ? AND YEAR(joined_at) = ? THEN 1 ELSE 0 END) as this_month_registered
            FROM members
        ", [
            $now->toDateString(),
            $now->month,
            $now->year,
        ]);

        $stats = [
            'total_members'         => (int)($statsRaw->total_members ?? 0),
            'today_registered'      => (int)($statsRaw->today_registered ?? 0),
            'this_month_registered' => (int)($statsRaw->this_month_registered ?? 0),
        ];

        return response()->json([
            'success'    => true,
            'members'    => $members->items(),
            'pagination' => [
                'total'        => $members->total(),
                'per_page'     => $members->perPage(),
                'current_page' => $members->currentPage(),
                'last_page'    => $members->lastPage(),
            ],
            'stats' => $stats,
        ], 200);
    }

    /**
     * 4️⃣  PUT /api/members/{id}
     * Update data anggota.
     */
    public function updateMember(Request $request, $id): JsonResponse
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'full_name'    => ['nullable', 'string', 'min:3', 'max:150'],
            'username'     => ['nullable', 'string', 'min:3', 'max:50', 'unique:members,username,' . $id],
            'institution'  => ['nullable', 'string', 'min:3', 'max:150'],
            'phone'        => ['nullable', 'string', 'regex:/^(0|62)[0-9]{9,13}$/'],
            'photo_base64' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $fillable = ['full_name', 'username', 'institution', 'phone', 'photo_base64'];
        foreach ($fillable as $field) {
            if ($request->has($field) && $request->input($field) !== null) {
                $member->$field = $request->input($field);
            }
        }

        $member->save();

        return response()->json([
            'success' => true,
            'member'  => $member->toArray(),
            'message' => 'Data anggota berhasil diperbarui.',
        ], 200);
    }

    /**
     * 5️⃣  DELETE /api/members/{id}
     * Hapus anggota.
     */
    public function deleteMember($id): JsonResponse
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota tidak ditemukan.',
            ], 404);
        }

        $fullName = $member->full_name;
        $member->delete();

        return response()->json([
            'success' => true,
            'message' => "Anggota '$fullName' berhasil dihapus.",
        ], 200);
    }

    /**
     * Bonus: GET /api/members/{id}
     * Ambil detail satu anggota.
     */
    public function getMember($id): JsonResponse
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'member'  => $member->toArray(),
        ], 200);
    }
}
