<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freepdf extends Model
{
    protected $table = 'free_pdfs';
    protected $fillable = [
        'course_id',
<<<<<<< Updated upstream
=======
        'unit_id',
        'package_id',
>>>>>>> Stashed changes
        'pdf_name',
        'pdf_file',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
<<<<<<< Updated upstream
=======

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
>>>>>>> Stashed changes
}
