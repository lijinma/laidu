<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\WechatAccount
 *
 * @property int $id
 * @property string $username
 * @property string $nickname
 * @property string $image
 * @property string $description
 * @property string $post_content_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\WechatAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatAccount whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatAccount whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatAccount whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatAccount whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatAccount wherePostContentUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatAccount whereUsername($value)
 * @mixin \Eloquent
 * @property int $added_by_user_id
 * @method static \Illuminate\Database\Query\Builder|\App\WechatAccount whereAddedByUserId($value)
 * @property bool $is_book_added 是否已经添加过
 * @method static \Illuminate\Database\Query\Builder|\App\WechatAccount whereIsBookAdded($value)
 */
class WechatAccount extends Model
{
    protected $guarded = [];
}
