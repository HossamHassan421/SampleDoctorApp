<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\WorkingHour
 *
 * @property int $id
 * @property string $uuid
 * @property int $type 1=half hour increment , 2=hour increment ,3=one and half hour increment ,4=two hour increment
 * @property string $name_en
 * @property string $name_ar
 * @property string $start_time
 * @property string $end_time
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHour withoutTrashed()
 * @mixin \Eloquent
 */
class WorkingHour extends Model
{
    use HasFactory,Sortable,SoftDeletes;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::generate()->string;
        });
    }
}
