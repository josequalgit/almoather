<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Notifications\AddInfluencer;
use Carbon\Carbon;
use App\Models\Ad;
use App\Console\Commands\CheckAdsCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CheckAdsCommand::class,
    ];
 
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('ads:check')->everyMinute()
        ->appendOutputTo(storage_path('logs/inspire.log'));
      //  $schedule->call(new CheckAdsCommand)->everyMinute();

       // $schedule->command(CheckAdsCommand::class, ['ads', '--force'])->everyMinute();


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

    private function get_ads_according_to_amount_of_days($amountOfDaysBehind ,$status , $col = null)
    {
        $from = Carbon::now()->subDays($amountOfDaysBehind)->startOfDay()->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');
       return Ad::whereBetween($col ?? 'update_at', [$from,$to])
        ->where('status',$status)
        ->get();
    }
}
