<?php

namespace App\Console\Commands;

use App\Page;
use Illuminate\Console\Command;

class UpdatePageOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page:update-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update page order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Page::withoutSyncingToSearch(function () {
            Page::chunk(100, function ($pages) {
                foreach ($pages as $page) {
                    if ($page->book && !$page->book->isWechat()) {
                        $page->order = 0;
                        $page->save();
                    }
                    //$page->order = $page->order + ($page->id % 20);
                }
                $this->info('完成了 100 条');
            });
        });
    }
}
