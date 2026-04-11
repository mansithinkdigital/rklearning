<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeVideo extends Model
{
    protected $fillable = [
        'title',
        'video_url',
    ];
}
