<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePackage extends Model
{
    protected $fillable = [
        'course_id',
        'package_id',
        'price',
        'image',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
