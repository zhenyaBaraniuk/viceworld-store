<?php

use App\Console\Commands\NovaPost\ImportCities;
use Illuminate\Support\Facades\Schedule;

Schedule::command(ImportCities::class)->dailyAt('2:00');
