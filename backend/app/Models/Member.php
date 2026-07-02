<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use Notifiable;

    // Arahkan ke tabel asli PHP Native Anda
    protected $table = 'members';

    // Kolom yang diizinkan untuk diisi massal
    protected $fillable = [
        'member_id',
        'full_name',
        'email',
        'username',
        'institution',
        'subject',
        'password',
        'role',
        'phone',
        'referral_code',
        'city',
        'photo_path',
        'photo_base64'
    ];

    // Sembunyikan data sensitif saat data diambil
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Nonaktifkan pencatatan created_at & updated_at otomatis bawaan Laravel
    // Karena tabel lama Anda menggunakan format 'joined_at'
    public $timestamps = false;

    /**
     * Auto-set joined_at saat member baru dibuat.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($member) {
            if (empty($member->joined_at)) {
                $member->joined_at = now();
            }
        });
    }

    /**
     * Generate Member ID unik dengan format GV-XXXXXXXX.
     * Contoh: GV-A3F92B1C
     */
    public static function generateMemberId(): string
    {
        do {
            $id = 'GV-' . strtoupper(Str::random(8));
        } while (self::where('member_id', $id)->exists());

        return $id;
    }
}
