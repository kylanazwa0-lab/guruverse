<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Module extends Model
{
    protected $table = 'gb_modules';

    protected $fillable = [
        'course_id', 'title', 'content', 'video_url',
        'duration_minutes', 'order', 'is_active',
        'module_number', 'type', 'description', 'file_path', 'quiz_data', 'order_index'
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'duration_minutes' => 'integer',
        'order'            => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
