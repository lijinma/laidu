<?php namespace App;

/**
 * App\UserBook
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\UserBook whereBookId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBook whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBook whereUserId($value)
 * @property-read \App\Book $book
 */
class UserBook extends Model
{
    protected $table = 'user_books';

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    protected static function boot()
    {
        parent::boot();
        self::saved(function (self $userBook) {
            Book::whereId($userBook->book_id)
                ->update(['selected_count' => UserBook::whereBookId($userBook->book_id)->count()]);
        });
    }
}
