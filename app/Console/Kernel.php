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
        //
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

        // group minutes
        // $schedule->call(function () {
        //     DB::table('groups')->where('notification_type','=','minutes')->where('type_data','=',5)->where('is_online','=',1);
        // })->everyFiveMinutes();

        // $schedule->call(function () {
        //     DB::table('groups')->where('notification_type','=','minutes')->where('type_data','=',10)->where('is_online','=',1);
        // })->everyTenMinutes();

        // $schedule->call(function () {
        //     DB::table('groups')->where('notification_type','=','minutes')->where('type_data','=',30)->where('is_online','=',1);
        // })->everyThirtyMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
