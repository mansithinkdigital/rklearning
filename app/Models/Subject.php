<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'course_id',
        'name',
    ];

    public function units()
    {
        return $this->hasMany(Unit::class)->orderBy('order');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
