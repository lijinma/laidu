<?php

namespace App\Console\Commands;

use App\Page;
use App\WechatPost;
use Illuminate\Console\Command;

class FixWechatPageOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat:fix-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix Wechat Page order.';

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
            Page::whereOrder(0)->chunk(100, function ($pages) {
                /** @var Page $page */
                foreach ($pages as $page) {
                    $post = WechatPost::whereUrlMd5(str_replace('.html', '', $page->url))->first();
                    if ($post) {
                        $page->order = strtotime($post->create_time) + ($page->id % 20);
                        $page->save();
                    }
                }
            });
        });
    }
}
