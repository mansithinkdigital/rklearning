<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Course extends Model
{
    protected $fillable = [
        'name',
        'image',
        'description',
        'long_description', // ✅ added
        'price',            // ✅ added
        'status',
        'price',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user');
    }

    public function paidVideos()
    {
        return $this->hasMany(PaidVideo::class);
    }
}
