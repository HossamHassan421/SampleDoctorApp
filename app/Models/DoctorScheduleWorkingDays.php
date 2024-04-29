<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\DoctorScheduleWorkingDays
 *
 * @property int $id
 * @property string $uuid
 * @property int $doctor_id
 * @property int $doctor_schedule_id
 * @property int $working_day_id
 * @property int $working_hour_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays query()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays whereDoctorScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays whereWorkingDayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays whereWorkingHourId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorScheduleWorkingDays withoutTrashed()
 * @property-read \App\Models\WorkingDay|null $workingDay
 * @property-read \App\Models\WorkingHour|null $workingHour
 * @mixin \Eloquent
 */
class DoctorScheduleWorkingDays extends Model
{
    use HasFactory,Sortable;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::generate()->string;
        });
    }

    public function workingDay()
    {
        return $this->belongsTo(WorkingDay::class, 'working_day_id');
    }

    public function workingHour()
    {
        return $this->belongsTo(WorkingHour::class, 'working_hour_id');
    }
}
