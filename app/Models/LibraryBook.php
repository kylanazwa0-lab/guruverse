<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryBook extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'title',
        'price',
        'image_url',
        'pdf_url',
        'category',
        'is_free',
        'author',
        'type',
        'status'
    ];
}
