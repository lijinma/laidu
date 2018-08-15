<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WechatPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('author')->nullable()->default(null);
            $table->string('username')->nullable()->default(null);
            $table->string('nickname')->nullable()->default(null);
            $table->text('content_url');
            $table->string('url_md5');
            $table->string('cover')->nullable()->default(null);
            $table->string('title')->nullable()->default(null);
            $table->text('digest')->nullable()->default(null);
            $table->integer('read_num')->nullable()->default(0);
            $table->integer('vote_num')->nullable()->default(0);
            $table->dateTime('create_time')->nullable()->default(null);
            $table->unique('url_md5');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_posts');
    }
}
