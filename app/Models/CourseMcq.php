<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMcq extends Model
{
    protected $fillable = [
        'course_subject_id',
        'question',
        'options',
        'answer',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function courseSubject()
    {
        return $this->belongsTo(CourseSubject::class);
    }
}
