<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = [
        'author_id',
        'title',
        'content',
        'image',
        'posted_at',
    ];

    protected $dates = [
        'posted_at'
    ];
}
