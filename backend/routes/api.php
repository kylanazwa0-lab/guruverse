<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\MateriController;

/*
|--------------------------------------------------------------------------
| API Routes — Guruverse Phase 2
|--------------------------------------------------------------------------
|
| Laravel SUDAH otomatis menambahkan prefix /api untuk file ini.
| Jadi Route::post('/register') → /api/register
|
| Endpoint:
|  POST   /api/register           — Pendaftaran (public)
|  POST   /api/login              — Login (public)
|  GET    /api/members            — Ambil semua (auth: sanctum)
|  GET    /api/members/{id}       — Ambil satu (auth: sanctum)
|  PUT    /api/members/{id}       — Update (auth: sanctum)
|  DELETE /api/members/{id}       — Hapus (auth: sanctum)
|  GET    /api/health             — Health check (public)
|
*/

// ─────────────────────────────────────────────────────────────────────
// PUBLIC ROUTES (tanpa auth)
// ─────────────────────────────────────────────────────────────────────

Route::post('/register', [MemberController::class, 'register']);
Route::post('/login', [MemberController::class, 'login']);

Route::get('/health', function () {
    return response()->json([
        'success'   => true,
        'message'   => 'API is running',
        'timestamp' => now(),
    ]);
});

// ─────────────────────────────────────────────────────────────────────
// PROTECTED ROUTES (memerlukan auth: sanctum)
// ─────────────────────────────────────────────────────────────────────

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/members', [MemberController::class, 'getMembers']);
    Route::get('/members/{id}', [MemberController::class, 'getMember']);
    Route::put('/members/{id}', [MemberController::class, 'updateMember']);
    Route::delete('/members/{id}', [MemberController::class, 'deleteMember']);

    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'user'    => $request->user(),
        ]);
    });

    // Materi (Media) Routes
    Route::post('/materi/upload', [MateriController::class, 'uploadMateri']);
    Route::post('/materi/mark-complete', [MateriController::class, 'markCourseComplete']);
    Route::get('/materi/{id}', [MateriController::class, 'show']);
    Route::get('/materi/{id}/download', [MateriController::class, 'downloadMateri']);
    Route::delete('/materi/{id}', [MateriController::class, 'deleteMateri']);
});