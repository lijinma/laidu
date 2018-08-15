<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserBook[] $userBooks
 * @property bool $is_vip
 * @property string $expired_in
 * @method static \Illuminate\Database\Query\Builder|\App\User whereExpiredIn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIsVip($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VipLog[] $vipLogs
 */
class User extends Authenticatable
{
    const JINME_ID = 1;
    const XIAOXI_ID = 2;

    const ADMIN_NAMES = [
        self::JINME_ID => '金马',
        self::XIAOXI_ID => '小溪'
    ];

    const FREE_BOOK_COUNT = 3;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function userBooks()
    {
        return $this->hasMany(UserBook::class);
    }

    public function hasBook(Book $book)
    {
        return UserBook::whereBookId($book->id)
            ->whereUserId($this->id)
            ->exists();
    }

    public function isAdmin()
    {
        return in_array($this->id, config('admin'));
    }

    public function addVipDuration($months, $remark = null)
    {
        $this->is_vip = 1;
        $startAt = $this->expired_in > date('Y-m-d H:i:s')
            ? $this->expired_in
            : date('Y-m-d') . ' 00:00:00';
        $timestamp = strtotime($startAt . ' +' . $months . 'months');
        $this->expired_in = date('Y-m-d H:i:s', $timestamp);
        $this->save();
        VipLog::create([
            'user_id' => $this->id,
            'months' => $months,
            'operation_user_id' => \Auth::id() ?: 1,
            'remark' => $remark
        ]);
    }

    public function vipLogs()
    {
        return $this->hasMany(VipLog::class);
    }

    public function isVipNow()
    {
        if (!$this->is_vip) {
            return false;
        }
        if (date('Y-m-d H:i:s') > $this->expired_in) {
            return false;
        }
        return true;
    }

    public function isPaidVip()
    {
        return (strtotime($this->expired_in) - strtotime($this->created_at)) > 60 * 86400;
    }

    public function getVipText()
    {
        if ($this->isVipNow()) {
            return '会员';
        }
        return '非会员';
    }

    public function canAddBook()
    {
        if ($this->isVipNow()) {
            return true;
        }
        if ($this->userBooks()->count() >= self::FREE_BOOK_COUNT) {
            return false;
        }
        return true;
    }

    public function canRemoveBook()
    {
        if ($this->isVipNow()) {
            return true;
        }
        if ($this->userBooks()->count() <= self::FREE_BOOK_COUNT) {
            return false;
        }
        return true;
    }

    public function canSearch()
    {
        if ($this->isVipNow()) {
            return true;
        }
        if ($this->userBooks()->count() <= self::FREE_BOOK_COUNT) {
            return true;
        }
        return false;
    }

    public function canViewBook()
    {
        if ($this->isVipNow()) {
            return true;
        }
        if ($this->userBooks()->count() <= self::FREE_BOOK_COUNT) {
            return true;
        }
        return true;
    }
}
