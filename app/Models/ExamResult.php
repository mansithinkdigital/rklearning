<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = [
        'user_id',
        'course_subject_id',
        'total_questions',
        'correct_answers',
        'score',
        'status',
        'student_answers'
    ];

    protected $casts = [
        'student_answers' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courseSubject()
    {
        return $this->belongsTo(CourseSubject::class);
    }
}
