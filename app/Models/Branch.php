<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'branch_name',
        'city',
        'state',
        'country',
        'postal',
        'contact',
        'branch_address',
        'password',
        'branch_id',
        'status',
    ];
}
