<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'limit',
        'period',
        'duration',
        'active',
    ];
}
