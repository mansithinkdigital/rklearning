<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'image',
        'description',
        'status',
    ];
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
