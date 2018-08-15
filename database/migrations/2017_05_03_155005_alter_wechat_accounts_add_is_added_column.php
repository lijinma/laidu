<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWechatAccountsAddIsAddedColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wechat_accounts', function (Blueprint $table) {
            $table->boolean('is_book_added')->after('post_content_url')->default(0)->comment('是否已经添加过');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wechat_accounts', function (Blueprint $table) {
            $table->dropColumn('is_book_added');
        });
    }
}
