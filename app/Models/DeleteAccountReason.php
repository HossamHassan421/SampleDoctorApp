<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\DeleteAccountReason
 *
 * @property int $id
 * @property string|null $uuid
 * @property string $reason_en
 * @property string $reason_ar
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason whereReasonAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason whereReasonEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DeleteAccountReason withoutTrashed()
 * @mixin \Eloquent
 */
class DeleteAccountReason extends Model
{
    use HasFactory, SoftDeletes;


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::generate()->string;
        });
    }
}
