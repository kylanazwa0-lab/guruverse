<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Member extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'members';
    protected $primaryKey = 'id';

    // Timestamp: joined_at = created_at, updated_at tetap
    public $timestamps = true;
    const CREATED_AT = 'joined_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Field yang boleh di-mass assign.
     */
    protected $fillable = [
        'member_id',
        'full_name',
        'username',
        'institution',
        'password',
        'phone',
        'photo_base64',
    ];

    /**
     * Field yang disembunyikan dari JSON response.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Cast tipe data otomatis.
     */
    protected $casts = [
        'joined_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Generate Member ID otomatis (001-GV-2026, 002-GV-2026, dst).
     *
     * @return string Format: NNN-GV-YYYY
     */
    public static function generateMemberId(): string
    {
        $year = now()->year;
        $lastMember = self::whereYear('joined_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastMember) {
            $nextNum = 1;
        } else {
            $parts = explode('-', $lastMember->member_id);
            $nextNum = intval($parts[0]) + 1;
        }

        return str_pad($nextNum, 3, '0', STR_PAD_LEFT) . '-GV-' . $year;
    }

    /**
     * Scope: Filter anggota aktif
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('joined_at');
    }

    /**
     * Scope: Cari berdasarkan username
     */
    public function scopeFindByLogin($query, $username)
    {
        return $query->where('username', $username);
    }

    /**
     * Scope: Cari berdasarkan phone
     */
    public function scopeFindByPhone($query, $phone)
    {
        return $query->where('phone', $phone);
    }

    /**
     * Custom JSON format untuk API response.
     */
    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'memberId'    => $this->member_id,
            'fullName'    => $this->full_name,
            'username'    => $this->username,
            'institution' => $this->institution,
            'phone'       => $this->phone,
            'photo'       => $this->photo_base64,
            'joinedAt'    => $this->joined_at?->format('Y-m-d H:i:s'),
        ];
    }
}