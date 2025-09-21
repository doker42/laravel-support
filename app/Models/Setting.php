<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value'
    ];

    public $timestamps = false;

    protected $table = 'settings';

    public const BOT_ENABLED = 'bot_enabled';
    public const CONTROL_LOG_ENABLED = 'control_log_enabled';

    public static function get(string $key, $default = null)
    {
        return optional(static::where('key', $key)->first())->value ?? $default;
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }


    public static function botEnabled($default = null)
    {
        return self::where('key', self::BOT_ENABLED)->first()->value ?? $default;
    }


    public static function controlLogEnabled($default = null)
    {
        return self::where('key', self::CONTROL_LOG_ENABLED)->first()->value ?? $default;
    }

}
