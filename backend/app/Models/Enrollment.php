<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $table = 'gb_enrollments';

    protected $fillable = [
        'user_id', 'course_id', 'status', 'progress_percent',
        'enrolled_at', 'completed_at',
    ];

    protected $casts = [
        'enrolled_at'     => 'datetime',
        'completed_at'    => 'datetime',
        'progress_percent'=> 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'user_id');
    }
}
