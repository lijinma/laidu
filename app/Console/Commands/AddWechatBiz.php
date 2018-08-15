<?php

namespace App\Console\Commands;

use App\Book;
use App\Lib\WechatPostSpider;
use App\WechatPost;
use Goutte\Client;
use Illuminate\Console\Command;

class AddWechatBiz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat:add-biz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add biz to wechat';

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
        Book::whereType(Book::TYPE_WECHAT)->chunk(100, function($books) {
            /** @var Book $book */
            foreach ($books as $book) {
                if (!$book->getBiz()) {
                    $this->addBiz($book);
                }
            }
        });
    }

    protected function addBiz(Book $book)
    {
        $client = new Client();
        $post = WechatPost::whereUsername($book->md5)->first();
        $wechat = new WechatPostSpider($client, $post->content_url);
        $book->setBiz($wechat->getBiz());
        $book->save();
    }
}
