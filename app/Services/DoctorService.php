<?php

namespace App\Services;

use App\Enum\AppointmentStatus;
use App\Enum\AppointmentType;
use App\Enum\DoctorFeesSettlingStatus;
use App\Enum\DoctorFeesSettlingType;
use App\Enum\DoctorScheduleType;
use App\Enum\DoctorType;
use App\Enum\EmergencyRequestStatus;
use App\Mail\DoctorCreation;
use App\Mail\DoctorResetPassword;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\DoctorScheduleWorkingDays;
use App\Models\EmergencyAppointment;
use App\Models\Groomer;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DoctorService extends BaseService
{
    /**
     * Register new doctor
     * @param $data // request data
     * @return bool
     * @throws \Throwable
     */
    public static function create($data)
    {
        DB::beginTransaction();
        try {
            $doctor = new Doctor;
            $doctor->type = DoctorType::doctor;
            $doctor->name = $data['name'];
            $doctor->email = $data['email'];
            $doctor->mobile = $data['mobile'];
            $doctor->doctor_percentage_fees = $data['doctor_percentage_fees'];
            $doctor->is_active = $data['is_active'];
            $password = self::randomPasswordGenerator();
            $doctor->password = Hash::make($password);
            $doctor->reset_password_flag = 1;
            $doctor->save();

            if (isset($data['working_schedule'])) {
                // Add doctor schedule if he is a new doctor
                self::addDoctorSchedule($doctor->id, $data);
            }

            // Send Email notification to new new doctor
            if (env('send_email_flag') && $data['email']) {
                $array['doctor'] = $doctor;
                $array['password'] = $password;
                Mail::to($data['email'])->send(new DoctorCreation($array));
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

    private static function addDoctorSchedule($doctor_id, $data)
    {
        $schedule = new DoctorSchedule();
        $schedule->type = DoctorScheduleType::doctor;
        $schedule->doctor_id = $doctor_id;
        $schedule->start_date = $data['start_date'];
        $schedule->end_date = $data['end_date'];
        $schedule->schedule_type = $data['schedule_type'];
        $schedule->save();
        foreach ($data['working_schedule'] as $working_day_key => $working_day) {
            if (!is_array($working_day)) {
                continue;
            }
            foreach ($working_day as $hour) {
                $schedule_working_days = new DoctorScheduleWorkingDays();
                $schedule_working_days->doctor_id = $doctor_id;
                $schedule_working_days->doctor_schedule_id = $schedule->id;
                $schedule_working_days->working_day_id = $working_day_key;
                $schedule_working_days->working_hour_id = $hour;
                $schedule_working_days->save();
            }
        }
    }

    public static function edit($uuid)
    {
        $model = Doctor::where('uuid', $uuid)->firstOrFail();
        return $model;
    }

    public static function update($data)
    {
        DB::beginTransaction();
        try {
            $model = Doctor::where('uuid', $data->uuid)->firstOrFail();
            $model->name = $data['name'];
            $model->email = $data['email'];
            $model->mobile = $data['mobile'];
            $model->doctor_percentage_fees = $data['doctor_percentage_fees'];
            $model->is_active = $data['is_active'];
            $model->save();
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public static function listing($model, $data)
    {
        $model = self::search($model, $data);
        // Sortable class is a trait used for dynamic sorting according to user needed.
        $model = $model->sortable()->orderByDesc('id')->paginate(20);
        return $model;
    }

    public static function listingAll($model, $data)
    {
        $model = self::search($model, $data);
        // Sortable class is a trait used for dynamic sorting according to user needed.
        return $model->sortable()->orderByDesc('id')->get();
    }

    private static function search($model, $data)
    {
        $model = $model->where('type', DoctorType::doctor);

        if ($data->has('uuid') && $data->uuid != null) {
            $model = $model->where('uuid', $data->uuid);
        }
        if ($data->has('name') && $data->name != null) {
            $model = $model->where('name', 'like', '%' . $data->name . '%');
        }
        if ($data->has('email') && $data->email != null) {
            $model = $model->where('email', 'like', $data->email . '%');
        }
        if ($data->has('mobile') && $data->mobile != null) {
            $model = $model->where('mobile', 'like', $data->mobile . '%');
        }
        if ($data->has('is_active') && $data->is_active !== null) {
            $model = $model->where('is_active', $data->is_active);
        }
        if ($data->has('is_verified') && $data->is_verified !== null) {
            $model = $model->where('is_verified', $data->is_verified);
        }
        if ($data->has('gender') && $data->gender != null) {
            $model = $model->where('gender', $data->gender);
        }
        if ($data->has('created_at') && $data->created_at != null) {
            $locale = app()->getLocale();
            if ($locale == 'ar') {
                $delimiter = ' إلى ';
            } else {
                $delimiter = ' to ';
            }
            $parts = explode($delimiter, $data->created_at);
            if (isset($parts[0]) && $parts[0] && !isset($parts[1])) {
                $model = $model->whereDate('created_at', $parts[0]);
            } else {
                if (isset($parts[0]) && $parts[0]) {
                    $model = $model->whereDate('created_at', '>=', $parts[0]);
                }
                if (isset($parts[1]) && $parts[1]) {
                    $model = $model->whereDate('created_at', '<=', $parts[1]);
                }
            }
        }
        return $model;
    }

    public static function activationToggle($request)
    {
        $record = Doctor::where('uuid', $request->uuid)->firstOrFail();
        if ($record->is_active == 0) {
            $record->is_active = 1;
            $record->save();
        } else {
            $record->is_active = 0;
            $record->save();
        }
    }

    public static function getByData($model, $data)
    {
        $model = $model->query();
        $model = self::search($model, $data);
        if ($data->has('getFirst') && $data->getFirst) {
            return $model->first();
        } elseif ($data->has('getCount') && $data->getCount) {
            return $model->count();
        } else {
            return $model->get();
        }
    }

    public static function changePassword($data)
    {
        $model = Doctor::where('uuid', $data->uuid)->firstOrFail();
        \DB::beginTransaction();
        try {
            if ($data->has('password') && $data->password != null) {
                $model->password = Hash::make($data->password);
            }
            $model->save();
            \DB::commit();
            return $model;
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }
    }

    public static function resetPassword($model)
    {
        DB::beginTransaction();
        try {
            $newPassword = self::randomPasswordGenerator(8);
            $model->password = Hash::make($newPassword);
            $model->reset_password_flag = 1;
            $check = $model->save();

            $data['doctor'] = $model;
            $data['newPassword'] = $newPassword;
            if (env('send_email_flag') && $check) {
                Mail::to($model->email)->send(new DoctorResetPassword($data));
            }
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function getDebitOfBoth()
    {
        return Doctor::select(
            DB::raw('SUM(CASE WHEN type = ' . DoctorType::doctor . ' THEN debit ELSE 0 END) AS total_doctor_debit'),
            DB::raw('SUM(CASE WHEN type = ' . DoctorType::groomer . ' THEN debit ELSE 0 END) AS total_groomer_debit')
        )->first();
    }

    public static function createFeesSettlingByDates($toDate)
    {
        $specialists = Doctor::where('is_active', 1)->get();
        foreach ($specialists as $key => $val) {
            DB::beginTransaction();
            try {
                $totalDoctorFees = AppointmentService::feesNotSettledByTypeDoctorDates(AppointmentType::health, $val->id, $toDate, null, [
                    'sumData' => 'doctor_fees'
                ]);
                $firstAppointment = AppointmentService::feesNotSettledByTypeDoctorDates(AppointmentType::health, $val->id, $toDate, null, [
                    'firstData' => true
                ]);

                $datetime_from = date('Y-m-d H:i:s');
                if ($firstAppointment) {
                    $firstAppointmentTime = date('Y-m-d H:i:s', strtotime($firstAppointment->date . ' ' . $firstAppointment->time));
                    if ($firstAppointmentTime < $datetime_from) {
                        $datetime_from = $firstAppointmentTime;
                    }
                }

                if ($totalDoctorFees) {
                    $doctorFeesSettling = DoctorFeesSettlingService::create([
                        'type' => DoctorFeesSettlingType::doctor,
                        'doctor_id' => $val->id,
                        'datetime_from' => date('Y-m-d H:i:s', strtotime($datetime_from)),
                        'datetime_to' => date('Y-m-d H:i:s', strtotime($toDate)),
                        'amount' => $totalDoctorFees,
                        'status' => DoctorFeesSettlingStatus::pending,
                    ]);
                    if ($firstAppointment) {
                        // update appointments
                        AppointmentService::feesNotSettledByTypeDoctorDates(AppointmentType::health, $val->id, $toDate, null, [
                            'updateData' => [
                                'fees_settling_id' => $doctorFeesSettling->id,
                                'fees_settling_status' => 2, // picked for invoice
                            ]
                        ]);
                    }
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                continue;
            }
        }
    }
}
