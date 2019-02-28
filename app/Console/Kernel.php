<?php

namespace BlaudCMS\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use BlaudCMS\Console\Commands\AuthBackendPermissionsCommand;
use BlaudCMS\Console\Commands\AuthFrontendPermissionsCommand;
use BlaudCMS\Console\Commands\ContentMenusCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AuthBackendPermissionsCommand::class,
        AuthFrontendPermissionsCommand::class,
        ContentMenusCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
