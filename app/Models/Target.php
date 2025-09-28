<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;


/**
 * @property int $id
 * @property int $telegraph_client_id
 * @property int $telegraph_chat_id
 * @property string $url
 * @property int $interval
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TargetStatus> $targetStatus
 * @property-read int|null $target_status_count
 * @method static Builder<static>|Target active()
 * @method static Builder<static>|Target newModelQuery()
 * @method static Builder<static>|Target newQuery()
 * @method static Builder<static>|Target query()
 * @method static Builder<static>|Target whereActive($value)
 * @method static Builder<static>|Target whereCreatedAt($value)
 * @method static Builder<static>|Target whereId($value)
 * @method static Builder<static>|Target wherePeriod($value)
 * @method static Builder<static>|Target whereTelegraphClientId($value)
 * @method static Builder<static>|Target whereUpdatedAt($value)
 * @method static Builder<static>|Target whereUrl($value)
 * @mixin \Eloquent
 */
class Target extends Model
{
    protected $fillable = [
        'telegraph_client_id',
        'telegraph_chat_id',
        'url',
        'interval',
        'previous_status',
        'last_status',
        'last_checked_at',
        'active'
    ];

    public const INTERVAL_DEFAULT = 300;

    public const STATUS_OK = 200;
    public const STATUS_NETWORK_ERROR = -1;
    public const STATUS_UNEXPECTED_ERROR = -2;

    public const STATUSES = [
        self::STATUS_NETWORK_ERROR    => 'network error',
        self::STATUS_UNEXPECTED_ERROR => 'unexpected error',
        self::STATUS_OK               => ' 200',
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


    public function client()
    {
        return $this->belongsTo(TelegraphClient::class, 'telegraph_client_id', 'id');
    }


    public function clients()
    {
        return $this->belongsToMany(TelegraphClient::class, 'target_client', 'target_id', 'telegraph_client_id');
    }

    /**
     * Проверяет корректность URL.
     *
     * @param string $url
     * @return array
     */
    public static function validateUrl(string $url): array
    {
        $message = '';
        $status  = true;

        if (empty($url)) {
            $message = "URL dont be empty. Try again";
            $status  = false;
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $message = "Invalid URL. . Try again";
            $status  = false;
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (!in_array($scheme, ['http', 'https'])) {
            $message = "URL should begin with http:// or https://. Try again";
            $status  = false;
        }

        return [
            'message' => $message,
            'status'  => $status,
        ];
    }


    public static function setActive(int $id, bool $active)
    {
        Target::where('id', $id)->update(['active' => $active]);
    }


    public static function getStatusText(string $key)
    {
        return self::STATUSES[$key];
    }

}
