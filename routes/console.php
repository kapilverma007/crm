<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Check for due-soon (30 min before) and overdue tasks every minute
Schedule::command('tasks:send-reminders')->everyMinute();

// Send birthday emails daily at 9:00 AM
Schedule::command('customers:send-birthday-emails')->dailyAt('09:00');
