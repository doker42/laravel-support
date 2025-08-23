<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

class Target extends Model
{
    protected $fillable = [
        'url',
        'period',
        'active'
    ];

    public function targetStatus(): HasMany
    {
        return $this->hasMany(TargetStatus::class, 'target_id');
    }

    /**
     * Scope a query to only include active users.
     */
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('active', 1);
    }
}
