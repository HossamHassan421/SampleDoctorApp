<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Appointment
 *
 * @property int $id
 * @property string $uuid
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $photo
 * @property int $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PetCategoryAge> $petCategoryAge
 * @property-read int|null $pet_category_age_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PetCategoryBreed> $petCategoryBreed
 * @property-read int|null $pet_category_breed_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PetCategoryWeight> $petCategoryWeight
 * @property-read int|null $pet_category_weight_count
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment withoutTrashed()
 * @property string $name
 * @property int $customer_id
 * @property int $pet_category_id
 * @property int $gender 1=male and 2=female
 * @property int|null $pet_category_age_id
 * @property int|null $pet_category_weight_id
 * @property int|null $pet_category_breed_id
 * @property-read \App\Models\Customer|null $customer
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePetCategoryAgeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePetCategoryBreedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePetCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePetCategoryWeightId($value)
 * @property int|null $customer_address_id
 * @property int $status 1=pending 2=doctor assigned 3=finished 4=canceled
 * @property string $date
 * @property string|null $time time of appointment
 * @property int|null $appointment_working_hour_id id of working_hour_id which customer chosen
 * @property int|null $doctor_id
 * @property int|null $doctor_schedule_id
 * @property int|null $doctor_schedule_working_day_id
 * @property float|null $net_totalling
 * @property float|null $vat
 * @property float|null $totalling
 * @property int|null $doctor_assigned_by
 * @property-read \App\Models\WorkingHour|null $appointmentWorkingHour
 * @property-read \App\Models\User|null $assignedBy
 * @property-read \App\Models\Doctor|null $doctor
 * @property-read \App\Models\DoctorSchedule|null $doctorSchedule
 * @property-read \App\Models\DoctorScheduleWorkingDays|null $doctorScheduleWorkingDay
 * @property-read \App\Models\WorkingHour|null $workingHour
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereAppointmentWorkingHourId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCustomerAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDoctorAssignedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDoctorScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDoctorScheduleWorkingDayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereNetTotalling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereTotalling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereVat($value)
 * @property int $type 1=health 2=grooming
 * @property float|null $payment_gateway_percentage
 * @property float|null $payment_gateway_fees
 * @property float|null $doctor_percentage
 * @property float|null $doctor_fees
 * @property float|null $pethome_fees
 * @property int|null $payment_method_id
 * @property string|null $visit_start_at
 * @property string|null $visit_end_at
 * @property-read \App\Models\AppointmentAddress|null $appointmentAddress
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentDetails> $appointmentDetails
 * @property-read int|null $appointment_details_count
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDoctorFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDoctorPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePaymentGatewayFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePaymentGatewayPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePethomeFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereVisitEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereVisitStartAt($value)
 * @property float|null $first_pet_visit_fees
 * @property float|null $other_pet_visit_fees
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereFirstPetVisitFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereOtherPetVisitFees($value)
 * @property int|null $fees_settling_id
 * @property int|null $fees_settling_status 1=not yet 2=picked for invoice 3=paid to doctor
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereFeesSettlingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereFeesSettlingStatus($value)
 * @mixin \Eloquent
 */
class Appointment extends Model
{
    use SoftDeletes;
    use Sortable;

    protected $table = 'appointments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'customer_address_id',
        'status',
        'date',
        'time',
        'appointment_working_hour_id',
        'doctor_id',
        'doctor_schedule_id',
        'doctor_schedule_working_day_id',
        'total_fees',
        'doctor_assigned_by',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::generate()->string;
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function doctorSchedule()
    {
        return $this->belongsTo(DoctorSchedule::class, 'doctor_schedule_id');
    }

    public function doctorScheduleWorkingDay()
    {
        return $this->belongsTo(DoctorScheduleWorkingDays::class, 'doctor_schedule_working_day_id');
    }

    public function appointmentWorkingHour()
    {
        return $this->belongsTo(WorkingHour::class, 'appointment_working_hour_id');
    }

    public function workingHour()
    {
        return $this->belongsTo(WorkingHour::class, 'working_hour_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'doctor_assigned_by');
    }

    public function appointmentAddress()
    {
        return $this->hasOne(AppointmentAddress::class, 'appointment_id')->where('type',1);
    }

    public function appointmentDetails()
    {
        return $this->hasMany(AppointmentDetails::class, 'appointment_id');
    }
}
