<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $table = 'gb_courses';

    protected $fillable = [
        'title', 'description', 'thumbnail', 'category',
        'duration_hours', 'level', 'is_active',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'duration_hours' => 'float',
    ];

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class, 'course_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'course_id');
    }
}
