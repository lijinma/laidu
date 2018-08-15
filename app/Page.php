<?php namespace App;

use Laravel\Scout\Searchable;

/**
 * App\Page
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $book_id
 * @property string $url
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereBookId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereUrl($value)
 * @property string $title
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereTitle($value)
 * @property-read \App\Book $book
 * @property string $url_hash
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereUrlHash($value)
 * @property string $order
 * @method static \Illuminate\Database\Query\Builder|\App\Page whereOrder($value)
 */
class Page extends Model
{
    use Searchable;
    public $searchSettings = [
        'attributesToHighlight' => [
            '*'
        ]
    ];
    protected $table = 'pages';

    public function toSearchableArray()
    {
        if (!$this->book) {
            return [
                'title' => '',
                'content' => '',
                'book_id' => 0,
            ];
        }
        $contentFile = storage_path('app/public/' . $this->book->md5 . '/' . $this->url);
        $contentFile = strtok($contentFile, "#");
        $content = file_get_contents($contentFile);
        $content = strip_tags($content);
        $content = str_replace(["\n"], '', $content);

        return [
            'title' => $this->title,
            'content' => $content,
            'book_id' => $this->book_id,
        ];
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function hasHtmlFile()
    {
        $folder = storage_path('app/public/') . $this->book->md5;
        $pageFile = $folder . '/' . $this->url;

        return file_exists($pageFile);
    }
}
