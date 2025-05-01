<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ProcessIrrigationSchedules::class,
        Commands\CheckWateringEvents::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Run every minute to check for schedules that need to start
        $schedule->command('irrigation:process-schedules')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/irrigation-schedules.log'));

        // Run every minute to check for watering events that need to be completed
        $schedule->command('irrigation:check-watering-events')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/irrigation-events.log'));
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
