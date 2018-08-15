<?php
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: lijinma
 * Date: 07/04/2017
 * Time: 9:25 AM
 */
class TestSeeder extends Seeder
{
    public function run()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'lijinma',
            'email' => 'lijinma@126.com'
        ]);
        /** @var \App\Book $book */
        $book = factory(\App\Book::class)->create([
            'title' => '把时间当做朋友',
            'file' => 'ba-shi-jian-dang-zuo-peng-you.epub',
            'md5' => '7fa8fcfa612989251007dafde19a1e86',
            'image' => '/covers/ba-shi-jian-dang-zuo-peng-you/cover.jpg',
            'description' => '有些时候，有些事物，从反面描述比从正面描述更为容易。如若先仔细说清楚这本书不是什么，之后对“它究竟是什么”这个问题，可能就不言自明了。',
            'is_public' => 1
        ]);
        factory(\App\Page::class)->create([
            'book_id' => $book->id,
            'title' => '简介',
            'url' => 'index.html',
        ]);
        factory(\App\Page::class)->create([
            'book_id' => $book->id,
            'title' => '历次出版前言',
            'url' => 'Preface.html',
        ]);
        factory(\App\Page::class)->create([
            'book_id' => $book->id,
            'title' => '序',
            'url' => 'Forword.html',
        ]);
        factory(\App\UserBook::class)->create([
            'book_id' => $book->id,
            'user_id' => $user->id,
        ]);
    }
}