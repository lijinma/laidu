<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\WechatPost
 *
 * @property int $id
 * @property string $author
 * @property string $username
 * @property string $content_url
 * @property string $url_md5
 * @property string $cover
 * @property string $title
 * @property string $digest
 * @property int $read_num
 * @property int $vote_num
 * @property string $create_time
 * @method static \Illuminate\Database\Query\Builder|\App\WechatPost whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatPost whereContentUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatPost whereCover($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatPost whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatPost whereDigest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatPost whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatPost whereReadNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatPost whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatPost whereUrlMd5($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatPost whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WechatPost whereVoteNum($value)
 * @mixin \Eloquent
 * @property string $nickname
 * @method static \Illuminate\Database\Query\Builder|\App\WechatPost whereNickname($value)
 */
class WechatPost extends Model
{
    protected $table = 'wechat_posts';
    public $timestamps = false;
    protected $guarded = [];
}
