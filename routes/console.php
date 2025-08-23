<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Schedule as ScheduleTarget;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


ScheduleTarget::command('targets:check 60')->everyMinute();
ScheduleTarget::command('targets:check 300')->everyMinute();
ScheduleTarget::command('targets:check 1800')->everyMinute();
ScheduleTarget::command('targets:check 3600')->everyMinute();

//return function (Schedule $schedule) {
//    $schedule->command('queue:work --stop-when-empty')->everyMinute();
//
//    $schedule->command('targets:check 60')->everyMinute();
//
//    $schedule->command('targets:check 300')->everyFiveMinutes();
//
//    $schedule->command('targets:check 1800')->everyThirtyMinutes();
//
//    $schedule->command('targets:check 3600')->hourly();
//};