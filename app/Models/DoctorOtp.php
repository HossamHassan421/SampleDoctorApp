<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;


/**
 * App\Models\DoctorOtp
 *
 * @property int $id
 * @property string $uuid
 * @property int $doctor_id
 * @property string $otp
 * @property string $expire_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorOtp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorOtp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorOtp query()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorOtp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorOtp whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorOtp whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorOtp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorOtp whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorOtp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorOtp whereUuid($value)
 * @mixin \Eloquent
 */
class DoctorOtp  extends Model
{
    use HasFactory;


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::generate()->string;
            $model->expire_at =Carbon::now()->addMinutes(5);
        });
    }

    public function doctor(){
        $this->belongsTo(Doctor::class,'doctor_id');
    }
}
