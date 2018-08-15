<?php

namespace App\Console;

use App\Console\Commands\AddBook;
use App\Console\Commands\AddWechatBiz;
use App\Console\Commands\CustomScout;
use App\Console\Commands\FetchMissingWechatPages;
use App\Console\Commands\FixWechatPageOrder;
use App\Console\Commands\GetWechatPosts;
use App\Console\Commands\InitEs;
use App\Console\Commands\OperateWechatAccount;
use App\Console\Commands\UnzipBook;
use App\Console\Commands\updateBookSelectedCount;
use App\Console\Commands\UpdatePageOrder;
use App\Console\Commands\WechatMenu;
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
        InitEs::class,
        GetWechatPosts::class,
        CustomScout::class,
        UpdatePageOrder::class,
        AddWechatBiz::class,
        OperateWechatAccount::class,
        updateBookSelectedCount::class,
        UnzipBook::class,
        AddBook::class,
        FixWechatPageOrder::class,
        WechatMenu::class,
        FetchMissingWechatPages::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('wechat-posts:get --env')
             ->hourly()
             ->withoutOverlapping();
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
