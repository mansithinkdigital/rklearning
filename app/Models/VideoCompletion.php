<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_id',
        'course_id',
        'is_completed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(PaidVideo::class, 'video_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
