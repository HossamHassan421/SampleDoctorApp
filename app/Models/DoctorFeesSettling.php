<?php

namespace App\Models;

use App\Enum\DoctorType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Webpatser\Uuid\Uuid;


/**
 * App\Models\DoctorFeesSettling
 *
 * @property int $id
 * @property string $uuid
 * @property int $type 1=doctor 2=groomer
 * @property int $doctor_id
 * @property string $datetime_from
 * @property string $datetime_to
 * @property float $amount
 * @property int $status 1=pending 2=paid
 * @property int|null $paid_by
 * @property string|null $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Doctor|null $doctor
 * @property-read \App\Models\Doctor|null $groomer
 * @property-read \App\Models\User|null $paidBy
 * @property-read \App\Models\Doctor|null $specialist
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling query()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling whereDatetimeFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling whereDatetimeTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling wherePaidBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorFeesSettling whereUuid($value)
 * @mixin \Eloquent
 */
class DoctorFeesSettling extends Model
{
    use Sortable;

    protected $table = 'doctors_fees_settling';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'type',
        'doctor_id',
        'datetime_from',
        'datetime_to',
        'amount',
        'status',
        'paid_by',
        'paid_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::generate()->string;
        });
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id')->where('type', DoctorType::doctor);
    }

    public function groomer()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id')->where('type', DoctorType::groomer);
    }

    public function specialist()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}
