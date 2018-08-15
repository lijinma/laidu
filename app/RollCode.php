<?php namespace App;

/**
 * App\RollCode
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $openid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\RollCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RollCode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RollCode whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RollCode whereUpdatedAt($value)
 */
class RollCode extends Model
{
    protected $table = 'roll_codes';

    public static function findOrCreateByOpenid($openid)
    {
        $rollCode = self::whereOpenid($openid)->first();
        if ($rollCode) {
            return $rollCode;
        }
        $rollCode = new self;
        $rollCode->openid = $openid;
        $rollCode->save();

        return $rollCode;
    }
}
