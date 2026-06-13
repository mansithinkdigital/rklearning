<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['subject_id', 'name', 'order'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class)->orderBy('order');
    }

    public function paidVideos()
    {
        return $this->hasMany(PaidVideo::class);
    }

    public function freePdfs()
    {
        return $this->hasMany(Freepdf::class);
    }
}
