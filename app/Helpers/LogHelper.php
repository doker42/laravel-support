<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class LogHelper
{

    public static function control($level, $message, array $context = []):void
    {
        if (config('app.control_log_enabled')) {
            Log::channel('checked_status')
                ->log($level, $message, $context);
        }
    }
}