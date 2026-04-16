<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaidVideo extends Model
{
    protected $fillable = [
        'course_id',
        'unit_id',
        'title',
        'video_id',
        'pdf',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
