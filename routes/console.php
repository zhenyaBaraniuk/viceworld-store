<?php

use App\Console\Commands\NovaPost\ImportCities;
use App\Console\Commands\NovaPost\ImportWarehouses;
use Illuminate\Support\Facades\Schedule;

Schedule::command(ImportCities::class)->dailyAt('2:00');
Schedule::command(ImportWarehouses::class)->dailyAt('2:30');
