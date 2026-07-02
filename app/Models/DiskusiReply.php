<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiskusiReply extends Model
{
    protected $table = 'gb_discussion_replies';

    protected $fillable = [
        'discussion_id',
        'user_id',
        'body',
        'attachment_path'
    ];

    public function discussion()
    {
        return $this->belongsTo(Diskusi::class, 'discussion_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'user_id');
    }
}
