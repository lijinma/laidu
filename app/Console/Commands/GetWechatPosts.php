<?php

namespace App\Console\Commands;

use App\Book;
use App\Lib\WechatPostSpider;
use App\Page;
use App\WechatPost;
use Goutte\Client;
use Illuminate\Console\Command;

class GetWechatPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat-posts:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Spider wechat posts.';

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
        $client = new Client();
        WechatPost::whereUsername(null)->chunk(100, function ($posts) use ($client) {
            /** @var WechatPost $post */
            foreach ($posts as $post) {
                try {
                    $url = $post->content_url;
                    $wechat = new WechatPostSpider($client, $url);
                    //先保存文件，有可能出错
                    $this->saveBookAndPage($wechat);
                    $post->username = $wechat->getUsername();
                    $post->author = $wechat->getAuthor();
                    $post->nickname = $wechat->getNickname();
                    $post->cover = $wechat->getCover();
                    $post->title = $wechat->getTitle();
                    $post->create_time = $wechat->getCreateTime();
                    $post->digest = $wechat->getDigest();
                    $post->save();
                } catch (\Exception $e) {
                    var_dump($e->getMessage());
                    sleep(1);
                    continue;
                }
            }
            sleep(1);
        });
    }

    protected function saveBookAndPage(WechatPostSpider $wechatPostSpider)
    {
        $username = $wechatPostSpider->getUsername();
        $book = Book::whereMd5($username)->first();
        if (!$book) {
            $book = $this->createWechatBook($wechatPostSpider);
        }
        $this->createWechatPage($book, $wechatPostSpider);
    }

    protected function createWechatPage(Book $book, WechatPostSpider $wechatPostSpider)
    {
        $url = md5($wechatPostSpider->getUrl()) . '.html';
        $page = Page::whereBookId($book->id)->whereUrl($url)->first();
        if ($page) {
            return;
        }
        $folder = storage_path('app/public/') . $book->md5;
        @mkdir($folder);
        $pageFile = $folder . '/' . $url;
        $html = $wechatPostSpider->getHtml();
        file_put_contents($pageFile, $html);
        $page = new Page();
        $page->url = $url;
        $page->book_id = $book->id;
        $page->title = $wechatPostSpider->getTitle();
        $page->save();
        $page->order = strtotime($wechatPostSpider->getCreateTime()) + ($page->id % 20);
        $page->save();
    }

    protected function createWechatBook(WechatPostSpider $wechatPostSpider)
    {
        $book = new Book();
        $book->md5 = $wechatPostSpider->getUsername();
        $book->title = $wechatPostSpider->getNickname();
        $book->image = $wechatPostSpider->getAccountImage();
        $book->description = $wechatPostSpider->getAccountDescription();
        $book->file = '';
        $book->type = Book::TYPE_WECHAT;
        $book->status = Book::STATUS_SUCCESS;
        $book->is_public = 1;
        $book->setBiz($wechatPostSpider->getBiz());
        $book->props = '';
        $book->save();

        return $book;
    }
}
