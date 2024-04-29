<?php

namespace App\Models;

use App\Enum\AppointmentType;
use App\Enum\DoctorScheduleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Doctor
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $mobile
 * @property string $email
 * @property string $password
 * @property string|null $image
 * @property int $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DoctorSchedule> $currentActiveSchedule
 * @property-read int|null $current_active_schedule_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DoctorSchedule> $schedules
 * @property-read int|null $schedules_count
 * @property string|null $country_code
 * @property int $is_verified
 * @property string|null $verified_at
 * @property int $reset_password_flag 1= reset password from admin 0= normal
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereResetPasswordFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereVerifiedAt($value)
 * @property int|null $gender 1=male and 2=female
 * @property int|null $delete_account_reason_id
 * @property string|null $temporary_mobile
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereDeleteAccountReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereTemporaryMobile($value)
 * @property int $type 1=doctor 2=groomer
 * @property float $doctor_percentage_fees
 * @property float|null $credit money owed to doctor by pethome
 * @property float|null $debit money owed to pethome by the doctor
 * @property float|null $balance
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereDoctorPercentageFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor currentActiveSchedule()
 * @mixin \Eloquent
 */
class Doctor extends Model
{
    use HasFactory, Sortable, SoftDeletes;


    protected $fillable = [
        'image',
        'name',
        'mobile',
        'email',
        'password',
        'is_active',
        'doctor_percentage_fees',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::generate()->string;
            $model->created_by = \Auth::user()->id;
        });
        self::updating(function ($model) {
            $model->updated_by = \Auth::user()->id;
        });
    }

    public static function getCurrentActiveSchedule($doctor)
    {
        return $doctor->currentActiveSchedule()->first();
    }

    public function scopeCurrentActiveSchedule($query)
    {
        $query->with(['schedules.scheduleWorkingDays.workingHour', 'schedules.scheduleWorkingDays.workingDay'])->schedules()->where('start_date', '>=', date('Y-m-d'))
            ->where('end_date', '<=', date('Y-m-d'))->where('is_active', 1);
    }

    public function currentActiveSchedule()
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_id')->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))->where('is_active', 1)
            ->where('type', DoctorScheduleType::doctor);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_id')->where('type', DoctorScheduleType::doctor);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id')->where('type', AppointmentType::health);
    }
}
