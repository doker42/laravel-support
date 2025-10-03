<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interval extends Model
{
    public const ALL = [
        60,
        300,
        600,
        900,
        1800,
        3600,
    ];

    public const FREE = [
        300,
        600,
    ];

    public const ARR = [
        'All'  => self::ALL,
        'Free' => self::FREE,
    ];

    protected $casts = [
        'intervals' => 'array',
    ];
}
