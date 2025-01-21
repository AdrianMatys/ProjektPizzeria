<?php

use App\Console\Commands\SendLowStockNotification;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command("notify:low-stock")
    ->weekdays()
    ->daily()
    ->at(18);
