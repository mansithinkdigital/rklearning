<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['unit_id', 'name', 'content', 'order'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
