<?php

namespace App\Services;

use App\Enum\AppointmentStatus;
use App\Enum\AppointmentType;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\WorkingDay;
use Illuminate\Validation\ValidationException;

class AppointmentService extends BaseService
{

    public static function feesNotSettledByTypeDoctorDates($type, $doctor_id, $dateTo, $fromDate = null, $action = [])
    {
        $appointments = Appointment::where('status', AppointmentStatus::finished)
            ->where('type', $type)
            ->where('doctor_id', $doctor_id)->where('fees_settling_status', 1); // not picked yet
        if (!empty($fromDate)) {
            $appointments = $appointments->where('date', '>=', date('Y-m-d', strtotime($fromDate)));
        }
        $appointments = $appointments->where('date', '<=', date('Y-m-d', strtotime($dateTo)))->orderBy('id');
        if(isset($action['updateData']) && $action['updateData']) {
            $appointments = $appointments->update($action['updateData']);
        } elseif(isset($action['firstData']) && $action['firstData']) {
            $appointments = $appointments->first();
        }  elseif(isset($action['sumData']) && $action['sumData']) {
            $appointments = $appointments->sum($action['sumData']);
        } else {
            $appointments = $appointments->get();
        }
        return $appointments;
    }
}
