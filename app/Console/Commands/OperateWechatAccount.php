<?php

namespace App\Console\Commands;

use App\Book;
use App\Lib\WechatPostSpider;
use App\WechatAccount;
use Goutte\Client;
use Illuminate\Console\Command;

class OperateWechatAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat:operate-account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '处理需要添加的公众号，获取这个公众号的基本信息';

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
        WechatAccount::where('is_book_added', 0)
            ->whereNull('username')
            ->orderBy('id', 'DESC')
            ->chunk(100, function ($accounts) use ($client) {
            /** @var WechatAccount $account */
            foreach ($accounts as $account) {
                try {
                    $url = $account->post_content_url;
                    $wechat = new WechatPostSpider($client, $url);
                    if ($wechat->getUsername() && $this->hasUsername($wechat->getUsername())) {
                        $account->delete();
                        continue;
                    }
                    $account->username = $wechat->getUsername();
                    $account->is_book_added = Book::whereMd5($account->username)->exists();
                    $account->save();
                } catch (\Exception $e) {
                    var_dump($e->getMessage());
                    continue;
                }
            }
        });
    }

    protected function hasUsername($username)
    {
        return WechatAccount::whereUsername($username)->exists();
    }
}
