<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class LogHelper
{
    public const CHANNEL_CHECKED_STATUS = 'checked_status';

    public static function control($level, $message, array $context = []):void
    {
        $controlLogEnabled = (bool) Setting::get(Setting::CONTROL_LOG_ENABLED, config('admin.control_log_enabled'));
        if ($controlLogEnabled) {
            Log::channel(self::CHANNEL_CHECKED_STATUS)
                ->log($level, $message, $context);
        }
    }
}