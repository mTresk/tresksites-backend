<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('horizon:snapshot')->everyFiveMinutes();
Schedule::command('db:backup')->hourly();