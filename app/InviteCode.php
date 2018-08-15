<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\InviteCode
 *
 * @property int $id
 * @property int $nickname
 * @property int $user_id
 * @property string $openid
 * @property int $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\InviteCode whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InviteCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InviteCode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InviteCode whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InviteCode whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InviteCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InviteCode whereUserId($value)
 * @mixin \Eloquent
 */
class InviteCode extends Model
{
    protected $guarded = [];

    public function hasUsed()
    {
        return $this->user_id;
    }

    public static function getCodeForOpenid($openid)
    {
        if ($inviteCode = self::whereOpenid($openid)->first()) {
            return $inviteCode->code;
        }
        $code = self::generateCodeForOpenid($openid);
        self::create([
            'openid' => $openid,
            'code' => $code
        ]);

        return $code;
    }

    public static function generateCodeForOpenid($openid)
    {
        $code = sprintf('%08d', rand(10000000, 99999999));
        if (self::where('code', $code)->exists()) {
            return self::generateCodeForOpenid($openid);
        }

        return $code;
    }

    public static function hasCodeAndNotUsed($code)
    {
        if (!$inviteCode = self::whereCode($code)->first()) {
            return false;
        }

        return $inviteCode->user_id == 0;
    }

    public static function setCodeUsedFor($code, User $user)
    {
        /** @var self $inviteCode */
        $inviteCode = self::whereCode($code)->firstOrFail();
        $inviteCode->user_id = $user->id;
        $inviteCode->save();
    }
}
