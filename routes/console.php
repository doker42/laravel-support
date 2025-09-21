<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule as ScheduleTarget;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


//ScheduleTarget::command('targets:check 60')->everyMinute();
//ScheduleTarget::command('targets:check 300')->everyMinute();
//ScheduleTarget::command('targets:check 1800')->everyMinute();
//ScheduleTarget::command('targets:check 3600')->everyMinute();

ScheduleTarget::command('subscriptions-update')->dailyAt('01:07');

ScheduleTarget::command('target-manager-command')->everyMinute();
//ScheduleTarget::command('monitor:start')->everyMinute();



Artisan::command('set-command', function () {
    $telBot = \DefStudio\Telegraph\Models\TelegraphBot::find(1);
    $telBot->registerCommands([
        'start'   => 'start work',
        'menu'    => 'menu',
        'targets' => 'targets list',
        'info'    => 'about',
        'add'     => 'add target',
    ])->send();

});