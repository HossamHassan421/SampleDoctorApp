<?php

namespace App\Models;

use App\Enum\DoctorType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\DoctorSchedule
 *
 * @property int $id
 * @property string $uuid
 * @property int $doctor_id
 * @property string $start_date
 * @property string $end_date
 * @property int $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule withoutTrashed()
 * @property int $schedule_type 1=half hour increment , 2=hour increment ,3=one and half hour increment ,4=two hour increment
 * @property-read \App\Models\Doctor|null $doctor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DoctorScheduleWorkingDays> $scheduleWorkingDays
 * @property-read int|null $schedule_working_days_count
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereScheduleType($value)
 * @property int $type 1=doctor 2=groomer
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorSchedule whereType($value)
 * @mixin \Eloquent
 */
class DoctorSchedule extends Model
{
    use HasFactory,Sortable,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::generate()->string;
        });
    }

    public function scheduleWorkingDays()
    {
        return $this->hasMany(DoctorScheduleWorkingDays::class, 'doctor_schedule_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id')->where('type', DoctorType::doctor);
    }
}
