<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:send-notifications-email')->everyMinute();

