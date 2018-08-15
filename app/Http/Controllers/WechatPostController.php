<?php

namespace App\Http\Controllers;

use App\Book;
use App\Lib\WechatPostSpider;
use App\WechatPost;
use Goutte\Client;
use Illuminate\Http\Request;

class WechatPostController extends Controller
{
    public function store(Request $request)
    {
        if ($request->header('Authorization') != 'lijinma') {
            return response('别闹了', 403);
        }
        $this->validate($request, [
            'content_url' => 'required',
            'read_num' => 'integer',
            'vote_num' => 'integer',
        ]);

        $contentUrl = $request->get('content_url');
        $contentUrl = str_replace('amp;', '', $contentUrl);
        $contentUrl = str_replace('\\/', '/', $contentUrl);
        $urlMd5 = md5($contentUrl);
        $post = WechatPost::where('url_md5', $urlMd5)->first();
        if (!$post) {
            WechatPost::create([
                'username' => $request->get('username'),
                'content_url' => $contentUrl,
                'url_md5' => $urlMd5,
                'cover' => $request->get('cover'),
                'title' => $request->get('title'),
                'digest' => $request->get('digest'),
                'read_num' => $request->get('read_num'),
                'vote_num' => $request->get('vote_num'),
                'create_time' => $request->get('create_time'),
            ]);

            if ($request->get('auto') && $request->get('nickname')) {
                return $this->getNextBook($request->get('nickname'));
            }

            return;
        }
        if ($request->get('read_num')) {
            $post->read_num = $request->get('read_num');
            $post->vote_num = $request->get('vote_num');
            $post->save();
        }

        $this->refreshFetchedAt($contentUrl);

        return ['next_biz' => $this->getNextBiz($contentUrl)];
    }

    /**
     * @param $contentUrl
     * @return Book
     */
    public function getNextBook($contentUrl)
    {
        $biz = $this->getBizFromContentUrl($contentUrl);
        $book = Book::whereBiz($biz)->whereType(Book::TYPE_WECHAT)->first();
        $nextBook = null;
        if ($book) {
            $nextBook = Book::whereType(Book::TYPE_WECHAT)
                ->where('id', '>', $book->id)
                ->where('fetched_at', '<', date('Y-m-d 00:00:00'))
                ->first();
        }
        if (!$nextBook) {
            $nextBook = Book::whereType(Book::TYPE_WECHAT)->first();
        }

        return $nextBook;
    }

    public function getNextBiz($username)
    {
        $nextBook = $this->getNextBook($username);
        if (!$nextBook) {
            return '';
        }

        return $nextBook->getBiz();
    }

    public function getBizFromContentUrl($contentUrl)
    {
        $components = parse_url($contentUrl);
        if (!isset($components['query'])) {
            return null;
        }
        $query = \GuzzleHttp\Psr7\parse_query($components['query']);

        if (!isset($query['__biz'])) {
            return null;
        }

        return $query['__biz'];
    }

    public function refreshFetchedAt($contentUrl)
    {
        $biz = $this->getBizFromContentUrl($contentUrl);
        if (!$biz) {
            return;
        }
        /** @var Book $book */
        $books = Book::whereBiz($biz)->whereType(Book::TYPE_WECHAT)->get();
        if ($books->count() < 1) {
            return;
        }
        foreach ($books as $book) {
            $book->fetched_at = date('Y-m-d H:i:s');
            $book->save();
        }
    }
}
