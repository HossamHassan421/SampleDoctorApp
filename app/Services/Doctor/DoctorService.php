<?php

namespace App\Services\Doctor;

use App\Models\Doctor;
use App\Models\DoctorOtp;
use App\Models\DeleteAccountReason;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Multicaret\Unifonic\UnifonicFacade;

use \stdClass;


class DoctorService extends BaseService
{

    public static function login($request)
    {
        $mobile = $mobile0 = $request->mobile;
        if (substr($mobile, 0, 1) !== "0") {
            $mobile0 = str_pad($mobile, strlen($mobile) + 1, "0", STR_PAD_LEFT);
        }
        $doctor = Doctor::where('mobile', $mobile)
            ->orWhere('mobile', $mobile0)
            ->first();
        if ($doctor == null) {
            throw ValidationException::withMessages(['user' => trans('system.not_registered')]);
        }

        if ($doctor->is_active == 0) {
            throw ValidationException::withMessages(['user' => trans('system.user_deactivated')]);
        }
        $doctorOtp = self::generateOtp($doctor);
        self::sendOtpSms($doctorOtp->otp, $doctor->mobile, $doctor->country_code);

        return $doctorOtp;
    }

    private static function generateOtp($doctor)
    {
        $doctorOtp = DoctorOtp::where('doctor_id', $doctor->id)->latest()->first();
        if ($doctorOtp && now()->isBefore($doctorOtp->expire_at)) {
            return $doctorOtp;
        }
        $doctorOtp = new DoctorOtp;
        $doctorOtp->doctor_id = $doctor->id;
        $doctorOtp->otp = 1111;
        $doctorOtp->save();
        return $doctorOtp;
    }

    public static function sendOtpSms($otp, $mobile, $country_code)
    {
//        if ($country_code == 'eg') {
//            $recipient = '+20' . ltrim($mobile, '0');
//        } else {
//            $recipient = '+966' . ltrim($mobile, '0');
//        }
//        $message = trans('system.otp_message_first_section') . $otp . trans('system.otp_message_last_section');
//        UnifonicFacade::send((int)$recipient, $message, $senderID = null);
    }

    public static function verifyOtp($request)
    {
        $doctorOtp = DoctorOtp::where('uuid', $request->uuid)->first();
        if ($doctorOtp == null)
            throw ValidationException::withMessages(['uuid' => 'reference not found']);

        if (Carbon::now()->gte($doctorOtp->expire_at))
            throw ValidationException::withMessages(['code_expired' => trans('system.code_expired')]);

        if ($doctorOtp->otp != $request->otp)
            throw ValidationException::withMessages(['wrong_code' => trans('system.wrong_code')]);

        $doctor = Doctor::find($doctorOtp->doctor_id);
        $doctor->is_verified = 1;
        $doctor->verified_at = Carbon::now();
        $doctor->save();

        return $doctor;
    }

    public static function UpdatePassword($request)
    {
        $doctor = auth('api-doctor')->user();
        if (!Hash::check($request->password, $doctor->password)) {
            throw ValidationException::withMessages(['user' => trans('doctor.not_valid_info')]);
        }
        $doctor->password = Hash::make($request->new_password);
        $doctor->save();
    }

    public static function updateProfile($request)
    {
        $doctor = auth('api-doctor')->user();
        $ready_to_save = false;
        if ($request->has('name')) {
            $doctor->name = $request->name;
            $ready_to_save = true;
        }
        if ($request->has('gender')) {
            $doctor->gender = $request->gender;
            $ready_to_save = true;
        }
        if ($request->has('email')) {
            $request->validate([
                'email' => 'email|unique:doctors,email,' . \Auth::guard('api-doctor')->user()->uuid . ',' . 'uuid',
                'password' => 'required'
            ]);
            if (!Hash::check($request->password, $doctor->password))
                throw ValidationException::withMessages(['user' => trans('system.not_valid_info')]);

            $doctor->email = $request->email;
        }
        if ($ready_to_save) {
            $doctor->save();
        }
        return $doctor;
    }

    public static function updateMobile($request)
    {
        $doctor = auth('api-doctor')->user();
        $mobile = $request->mobile;
        if (substr($mobile, 0, 1) !== "0") {
            $mobile = str_pad($mobile, strlen($mobile) + 1, "0", STR_PAD_LEFT);
        }

        $doctor->temporary_mobile = $mobile;
        $doctor->save();
        $doctorOtp = self::generateOtp($doctor);
        self::sendOtpSms($doctorOtp->otp, $doctor->temporary_mobile, $doctor->country_code);

        return $doctorOtp;
    }

    public static function verifyUpdateMobileOtp($request)
    {
        $doctorOtp = DoctorOtp::where('uuid', $request->uuid)->first();

        if ($doctorOtp == null)
            throw ValidationException::withMessages(['uuid' => 'reference not found']);

        if (Carbon::now()->gte($doctorOtp->expire_at))
            throw ValidationException::withMessages(['code_expired' => trans('system.code_expired')]);

        if ($doctorOtp->otp != $request->otp)
            throw ValidationException::withMessages(['wrong_code' => trans('system.wrong_code')]);

        $doctor = Doctor::find($doctorOtp->doctor_id);
        if ($doctor->temporary_mobile != null) {
            $doctor->mobile = $doctor->temporary_mobile;
        }
        $doctor->temporary_mobile = null;
        $doctor->save();

        return $doctor;
    }

    public static function updateProfilePicture($request)
    {
        $doctor = auth('api-doctor')->user();
        $image = self::uploadImage($request->image, 'uploads/images/doctor', $doctor->image);
        $doctor->image = $image;
        $doctor->save();
        return $doctor;
    }

    public static function deleteProfilePicture()
    {
        $doctor = auth('api-doctor')->user();
        unlink($doctor->image);
        $doctor->image = null;
        $doctor->save();
        return $doctor;
    }

    public static function deleteAccount($request)
    {
        $doctor = auth('api-doctor')->user();

        if (!Hash::check($request['password'], $doctor->password)) {
            throw ValidationException::withMessages(['user' => trans('system.not_valid_info')]);
        }

        $deleteReason = DeleteAccountReason::where('uuid', $request['delete_reason'])->first();
        if ($deleteReason == null) {
            throw ValidationException::withMessages(['user' => trans('reason not found')]);
        }

        $doctor->delete_account_reason_id = $deleteReason->id;
        $doctor->is_verified = 0;
        $doctor->save();
        $doctor->delete();
    }
}
