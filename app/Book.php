<?php namespace App;

/**
 * App\Book
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property string $file
 * @property string $md5
 * @property string $url
 * @property string $image
 * @property bool $is_public
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereFile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereIsPublic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereMd5($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereUrl($value)
 * @property string $name
 * @property string $description
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereName($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Page[] $pages
 * @property bool $type 书籍类型: epub,mobi,wechat
 * @property bool $status 状态：正在处理
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereType($value)
 * @property string $props 额外字段
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereProps($value)
 * @property string $biz 公众号 biz
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereBiz($value)
 * @property int $selected_count 被用户选择的次数
 * @property string $fetched_at 最后抓取时间
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereFetchedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereSelectedCount($value)
 */
class Book extends Model
{
    protected $table = 'books';

    const TYPE_EPUB = 1;
    const TYPE_MOBI = 2;
    const TYPE_WECHAT = 3;

    const STATUS_PENDING = 0;
    const STATUS_SUCCESS = 1;

    const TYPE_TEXTS = [
        self::TYPE_EPUB => 'epub',
        self::TYPE_MOBI => 'mobi',
        self::TYPE_WECHAT => 'wechat'
    ];

    const TYPE_LABELS = [
        self::TYPE_EPUB => 'EPUB',
        self::TYPE_MOBI => 'MOBI',
        self::TYPE_WECHAT => '公众号'
    ];

    const TYPE_TEXTS_REVERSE = [
        'epub' => self::TYPE_EPUB,
        'mobi' => self::TYPE_MOBI,
        'wechat' => self::TYPE_WECHAT,
    ];

    public function pages()
    {
        return $this->hasMany(Page::class)->orderBy('order', 'desc')->orderBy('id', 'asc');
    }

    public function isEpub()
    {
        return $this->type == self::TYPE_EPUB;
    }

    public function isMobi()
    {
        return $this->type == self::TYPE_MOBI;
    }

    public function isWechat()
    {
        return $this->type == self::TYPE_WECHAT;
    }

    public function isStatusSuccess()
    {
        return $this->status == self::STATUS_SUCCESS;
    }

    public function setBiz($biz)
    {
        $this->biz = $biz;
    }

    public function getBiz()
    {
        return $this->biz;
    }

    protected static function boot()
    {
        self::created(function(self $book) {
            $book->fetched_at = date('Y-m-d H:i:s');
            $book->save();
        });
    }

}
