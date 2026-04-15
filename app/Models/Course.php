<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'image',
        'description',
        'long_description', // ✅ added
        'price',            // ✅ added
        'status',
    ];
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
