<?php

namespace App\Console\Commands;

use App\Lib\WechatPostSpider;
use App\Page;
use App\WechatPost;
use Goutte\Client;
use Illuminate\Console\Command;

class FetchMissingWechatPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat:fetch-missing-pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch missing pages.';

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
        $this->all();
//        $this->forBook(43);
    }

    protected function forBook($bookId)
    {
        Page::whereBookId($bookId)->chunk(1000, function ($pages) use ($bookId) {
            foreach ($pages as $page) {
                if ($page->book && $page->book->isWechat()) {
                    if (!$page->hasHtmlFile()){
                        $this->fetchPage($page);
                    }
                }
            }
            $this->info('完成了 1000 条 for book: ' . $bookId);
        });
    }

    protected function all()
    {
        Page::chunk(1000, function ($pages) {
            foreach ($pages as $page) {
                if ($page->book && $page->book->isWechat()) {
                    if (!$page->hasHtmlFile()){
                        $this->fetchPage($page);
                    }
                }
            }
            $this->info('完成了 1000 条');
        });
    }

    protected function fetchPage(Page $page)
    {
        $md5 = str_replace('.html', '', $page->url);
        $post = WechatPost::whereUrlMd5($md5)->first();
        if (!$post) {
            return;
        }
        $client = new Client();
        $url = $post->content_url;
        $wechat = new WechatPostSpider($client, $url);


        $folder = storage_path('app/public/') . $page->book->md5;
        @mkdir($folder);
        $pageFile = $folder . '/' . $page->url;
        $html = $wechat->getHtml();
        file_put_contents($pageFile, $html);
        sleep(1);
    }
}
