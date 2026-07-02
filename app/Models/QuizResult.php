<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $table = 'gb_quiz_results';

    protected $fillable = [
        'course_id',
        'module_number',
        'user_id',
        'score',
        'answers'
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
