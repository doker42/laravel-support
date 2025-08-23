<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetStatus extends Model
{
    protected $fillable = [
        'target_id' ,
        'stop_date',
        'start_date'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'stop_date'  => 'datetime',
    ];

    protected $table = 'target_statuses';
}
