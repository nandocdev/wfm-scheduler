<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('communications:publish-scheduled')
    ->everyFiveMinutes()
    ->withoutOverlapping();

Schedule::command('communications:auto-archive')
    ->hourly()
    ->withoutOverlapping();

Schedule::command('communications:send-expired-poll-reminders')
    ->hourly()
    ->withoutOverlapping();

Schedule::command('communications:send-newsletter')
    ->dailyAt('08:00')
    ->withoutOverlapping();
