<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'gb_certificates';

    protected $fillable = [
        'user_id',
        'course_id',
        'certificate_number',
        'issued_at',
        'is_verified',
        'pdf_path',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    /**
     * Relation: Certificate belongs to Member (User)
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'user_id');
    }

    /**
     * Relation: Certificate belongs to Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
