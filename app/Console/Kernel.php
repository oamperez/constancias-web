<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\FileEmail;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        FileEmail::class
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email:constancy')->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
