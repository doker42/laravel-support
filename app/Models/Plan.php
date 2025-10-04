<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'price',
        'limit',
        'interval',
        'duration',
        'active',
        'default',
        'regular',
        'intervals',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($plan) {
            if ($plan->default == 1) {
                static::where('id', '!=', $plan->id)->update(['default' => 0]);
            }
        });
    }
}
