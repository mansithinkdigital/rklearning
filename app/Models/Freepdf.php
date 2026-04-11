<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freepdf extends Model
{
    protected $table = 'free_pdfs';
    protected $fillable = [
        'course_id',
        'package_id',
        'pdf_name',
        'pdf_file',
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
