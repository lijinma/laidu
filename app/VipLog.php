<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\VipLog
 *
 * @property int $id
 * @property int $user_id
 * @property int $seconds
 * @property int $operation_user_id
 * @property string $remark
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\VipLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VipLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VipLog whereOperationUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VipLog whereRemark($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VipLog whereSeconds($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VipLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VipLog whereUserId($value)
 * @mixin \Eloquent
 * @property int $months
 * @method static \Illuminate\Database\Query\Builder|\App\VipLog whereMonths($value)
 */
class VipLog extends Model
{
    protected $guarded = [];
}
