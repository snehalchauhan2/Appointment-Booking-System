<?php

namespace LaraBooking\Console;

use Illuminate\Console\Scheduling\Appointment;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command appointment.
     *
     * @param  \Illuminate\Console\Scheduling\Appointment  $appointment
     * @return void
     */
    protected function appointment(Appointment $appointment)
    {
        // $appointment->command('inspire')
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
