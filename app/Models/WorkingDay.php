<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\WorkingDay
 *
 * @property int $id
 * @property string $uuid
 * @property string $name_en
 * @property string $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingDay sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingDay whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingDay whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingDay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingDay whereUuid($value)
 * @mixin \Eloquent
 */
class WorkingDay extends Model
{
    use HasFactory,Sortable;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::generate()->string;
        });
    }
}
