<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('backup:clean')->daily();
Schedule::command('backup:run --only-db')->daily();
Schedule::command('activitylog:clean')->daily();
Schedule::command('queue:work --stop-when-empty')->everyMinute();
