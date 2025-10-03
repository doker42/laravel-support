<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TargetClient extends Model
{
    protected $fillable = [
        'chat_id',
        'target_id',
        'telegraph_client_id',
        'interval',
        'active',
    ];

    protected $table = 'target_client';

    protected static function booted()
    {
        static::saved(fn($client)   => $client->updateTargetInterval());
        static::updated(fn($client) => $client->updateTargetInterval());
        static::deleted(fn($client) => $client->updateTargetInterval());
    }

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(TelegraphClient::class, 'telegraph_client_id', 'id');
    }

    public static function setActive(int $target_id, int $telegraph_client_id, bool $active)
    {
        self::where([
            'target_id' => $target_id,
            'telegraph_client_id' => $telegraph_client_id
        ])->update(['active' => $active]);
    }

    public static function remove(int $target_id, int $telegraph_client_id)
    {
        self::where([
            'target_id' => $target_id,
            'telegraph_client_id' => $telegraph_client_id
        ])->delete();
    }

    public static function get($targetId, $clientId)
    {
        return self::where([
            'target_id'           => $targetId,
            'telegraph_client_id' => $clientId
        ])->first();
    }

    public static function exists(string $text, TelegraphClient $client): bool
    {
        $target = Target::where('url', $text)->first();

        if (!$target) {
            return false;
        }

        return (bool) self::where([
            'target_id'           => $target->id,
            'telegraph_client_id' => $client->id
        ])->first();
    }


    public function updateTargetInterval(): void
    {
        $min = $this->target
            ->clients()
            ->where('active', 1)
            ->min('interval') ?? Target::INTERVAL_DEFAULT;
        $this->target->update(['interval' => $min]);
    }
}
