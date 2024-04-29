<?php

namespace App\Services;

use App\Enum\AppointmentStatus;
use App\Enum\DoctorFeesSettlingStatus;
use App\Enum\DoctorFeesSettlingType;
use App\Enum\DoctorType;
use App\Enum\TransactionType;
use App\Models\DoctorFeesSettling;
use App\Models\PaymentMethod;
use DB;
use Illuminate\Validation\ValidationException;

class DoctorFeesSettlingService extends BaseService
{
    public static function listing($data = [])
    {
        $model = self::search($data);
        $model = $model->sortable()->orderByDesc('id')->paginate(20);
        return $model;
    }

    public static function listingAll($data = [])
    {

        $model = self::search($data);
        $model = $model->sortable()->orderByDesc('id');
        return $model->get();
    }

    private static function search($data = [])
    {
        $model = DoctorFeesSettling::query();
        $model = $model->with(['groomer', 'doctor']);

        if (isset($data['id']) && $data['id'] != null) {
            $model = $model->where('id', $data['id']);
        }
        if (isset($data['uuid']) && $data['uuid'] != null) {
            $model = $model->where('uuid', $data['uuid']);
        }
        if (isset($data['doctor_id']) && $data['doctor_id'] != null) {
            $model = $model->whereHas('specialist', function ($q) use ($data) {
                $q->where('doctors.id', $data['doctor_id'])
                    ->where('doctors.type', DoctorType::doctor);
            });
        }
        if (isset($data['groomer_id']) && $data['groomer_id'] != null) {
            $model = $model->whereHas('specialist', function ($q) use ($data) {
                $q->where('doctors.id', $data['groomer_id'])
                    ->where('doctors.type', DoctorType::groomer);
            });
        }
        if (isset($data['status']) && $data['status'] !== null) {
            $model = $model->where('doctor_fees_settling.status', $data['status']);
        }
        if (isset($data['created_at']) && $data['created_at'] != null) {
            if (app()->getLocale() == 'ar') {
                $delimiter = ' إلى ';
            } else {
                $delimiter = ' to ';
            }
            $parts = explode($delimiter, $data['created_at']);
            if (isset($parts[0]) && $parts[0] && !isset($parts[1])) {
                $model = $model->whereDate('doctor_fees_settling.created_at', $parts[0]);
            } else {
                if (isset($parts[0]) && $parts[0]) {
                    $model = $model->whereDate('doctor_fees_settling.created_at', '>=', $parts[0]);
                }
                if (isset($parts[1]) && $parts[1]) {
                    $model = $model->whereDate('doctor_fees_settling.created_at', '<=', $parts[1]);
                }
            }
        }
        return $model;
    }

    public static function getBy($data = [])
    {
        $model = self::search($data);
        if (isset($data['getFirstOrFail']) && $data['getFirstOrFail']) {
            return $model->firstOrFail();
        }
        if (isset($data['getFirst']) && $data['getFirst']) {
            return $model->first();
        } elseif (isset($data['getCount']) && $data['getCount']) {
            return $model->count();
        } else {
            return $model->get();
        }
    }

    public static function getAppointmentsCountByDoctor($data)
    {
        $appointments = AppointmentService::getBy([
            'getCount' => true,
            'doctor_id' => $data->doctor_id,
//            'from_date' => $data->datetime_from,
//            'to_date' => $data->datetime_to,
            'status' => AppointmentStatus::finished,
            'fees_settling_id' => $data->id
        ], $data->type);
        if ($data->type == DoctorFeesSettlingType::doctor) {
            $emergencyAppointments = EmergencyRequestService::getBy([
                'getCount' => true,
                'doctor_id' => $data->doctor_id,
//            'from_date' => $data->datetime_from,
//            'to_date' => $data->datetime_to,
                'status' => AppointmentStatus::finished,
                'fees_settling_id' => $data->id
            ]);
            return $appointments + $emergencyAppointments;
        } elseif ($data->type == DoctorFeesSettlingType::groomer) {
            return $appointments;
        } else {
            return 0;
        }
    }

    public static function getAppointmentsCountByDoctorAndPaymentMethod($data)
    {
        $paymentMethods = PaymentMethod::all();
        $array = array();
        foreach ($paymentMethods as $key => $val) {
            $array[$val->id]['name'] = $val['name_' . app()->getLocale()];
            $appointments = AppointmentService::getBy([
                'getCount' => true,
                'doctor_id' => $data->doctor_id,
//            'from_date' => $data->datetime_from,
//            'to_date' => $data->datetime_to,
                'payment_method_id' => $val->id,
                'status' => AppointmentStatus::finished,
                'fees_settling_id' => $data->id
            ], $data->type);
            if ($data->type == DoctorFeesSettlingType::doctor) {
                $emergencyAppointments = EmergencyRequestService::getBy([
                    'getCount' => true,
                    'doctor_id' => $data->doctor_id,
//            'from_date' => $data->datetime_from,
//            'to_date' => $data->datetime_to,
                    'payment_method_id' => $val->id,
                    'status' => AppointmentStatus::finished,
                    'fees_settling_id' => $data->id
                ]);
                $appointments += $emergencyAppointments;
            }
            $array[$val->id]['count'] = $appointments;
        }
        return $array;
    }

    public static function payInvoice($model)
    {
        if ($model->status != DoctorFeesSettlingStatus::pending) {
            throw ValidationException::withMessages(['message' => __('doctorFeesSettling.this_invoice_already_paid')]);
        }
        if (!$model->specialist->exists()) {
            throw ValidationException::withMessages(['message' => __('doctorFeesSettling.error_in_specialist_data_with_this_invoice')]);

        }
        $doctor = $model->specialist;
        if ($doctor->credit < $model->amount) {
            throw ValidationException::withMessages(['message' => __('doctorFeesSettling.the_amount_of_invoice_is_greater_than_the_specialist_credit')]);
        }
        DB::beginTransaction();
        try {
            $doctor->credit -= $model->amount;
            $doctor->save();

            TransactionService::create([
                'type' => TransactionType::doctorFeesSettling,
                'reference_id' => $model->id,
                'transaction_value' => $model->amount,
                'income_value' => (int)-$model->amount,
                'doctor_id' => $doctor->id
            ]);

            AppointmentService::getBy([
                'doctor_id' => $doctor->id,
                'status' => AppointmentStatus::finished,
                'fees_settling_id' => $model->id,
                'updateData' => [
                    'fees_settling_status' => 3 // paid to doctor
                ]
            ], $model->type);
            if ($model->type == DoctorFeesSettlingType::doctor) {
                EmergencyRequestService::getBy([
                    'doctor_id' => $doctor->id,
                    'status' => AppointmentStatus::finished,
                    'fees_settling_id' => $model->id,
                    'updateData' => [
                        'fees_settling_status' => 3 // paid to doctor
                    ]
                ]);
            }

            $model->status = DoctorFeesSettlingStatus::paid;
            $model->paid_by = auth()->user()->id;
            $model->paid_at = date('Y-m-d H:i:s');
            $model->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public static function create($data = [])
    {
        $model = new DoctorFeesSettling();
        $model->type = $data['type'];
        $model->doctor_id = $data['doctor_id'];
        $model->datetime_from = $data['datetime_from'];
        $model->datetime_to = $data['datetime_to'];
        $model->amount = $data['amount'];
        $model->status = $data['status'];
        $model->save();
        return $model;
    }

}
