<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diskusi extends Model
{
    protected $table = 'gb_discussions';

    protected $fillable = [
        'course_id',
        'module_number',
        'user_id',
        'title',
        'body',
        'category',
        'status'
    ];

    public function replies()
    {
        return $this->hasMany(DiskusiReply::class, 'discussion_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
