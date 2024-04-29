<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\DoctorApp\Doctor\LoginRequest;
use App\Http\Requests\DoctorApp\Doctor\UpdatePasswordRequest;
use App\Http\Requests\DoctorApp\Doctor\VerifyOtpRequest;
use App\Http\Requests\DoctorApp\Doctor\UpdateProfileRequest;
use App\Http\Requests\DoctorApp\Doctor\UpdateMobileRequest;
use App\Http\Requests\DoctorApp\Doctor\UpdateProfilePictureRequest;
use App\Http\Requests\DoctorApp\Doctor\DeleteAccountRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\DoctorApp\Doctor\AuthResource;
use App\Http\Resources\DoctorApp\Doctor\InfoResource;
use App\Http\Resources\DoctorApp\Doctor\UpdatePasswordSuccessResource;
use App\Http\Resources\DoctorApp\Doctor\OtpResource;
use App\Services\Doctor\DoctorService;
use Illuminate\Http\Request;
use App\Http\Resources\DoctorApp\Doctor\DeleteAccountReasonResource;
use App\Models\DeleteAccountReason;
use \stdClass;

class DoctorController extends BaseController
{
    /**
     * Generate Doctor OTP to be validate
     * @param LoginRequest $request to validate the request data
     * @return OtpResource
     */
    function login(LoginRequest $request)
    {
        $doctorOtp = DoctorService::login($request);
        return new OtpResource($doctorOtp);
    }

    /**
     * Validate Doctor OTP and create new token
     * @param VerifyOtpRequest $request to validate the request data
     * @return AuthResource
     */
    function verifyOtp(VerifyOtpRequest $request)
    {
        $customer= DoctorService::verifyOtp($request);
        return new AuthResource($customer);
    }

    /**
     * Update doctor password
     * @param UpdatePasswordRequest $request to validate the request data
     * @return UpdatePasswordSuccessResource
     */
    function updatePassword(UpdatePasswordRequest $request)
    {
        DoctorService::UpdatePassword($request);
        return new UpdatePasswordSuccessResource(new stdClass());
    }

    /**
     * Get doctor profile data
     * @param Request $request to validate the request data
     * @return InfoResource
     */
    function doctorProfile(Request $request)
    {
        $doctor = auth('api-doctor')->user();
        return new InfoResource($doctor);
    }

    /**
     * Update doctor profile
     * @param UpdateProfileRequest $request to validate the request data
     * @return InfoResource
     */
    function updateProfile(UpdateProfileRequest $request)
    {
        $doctor= DoctorService::updateProfile($request);
        return new InfoResource($doctor);
    }

    /**
     * Generate new OTP to update doctor mobile
     * @param UpdateMobileRequest $request to validate the request data
     * @return OtpResource
     */
    function updateMobile(UpdateMobileRequest $request)
    {
        $doctorOtp= DoctorService::updateMobile($request);
        return new OtpResource($doctorOtp);
    }

    /**
     * Verify the OTP and update doctor mobile
     * @param VerifyOtpRequest $request to validate the request data
     * @return InfoResource
     */
    function verifyDoctorUpdateMobileOtp(VerifyOtpRequest $request)
    {
        $customer= DoctorService::verifyUpdateMobileOtp($request);
        return new InfoResource($customer);
    }

    /**
     * Update doctor profile picture
     * @param UpdateProfilePictureRequest $request to validate the request data
     * @return InfoResource
     */
    function updateProfilePicture(UpdateProfilePictureRequest $request)
    {
        $customer= DoctorService::updateProfilePicture($request);
        return new InfoResource($customer);
    }

    /**
     * Delete doctor profile picture
     * @param Request $request to validate the request data
     * @return InfoResource
     */
    function deleteProfilePicture(Request $request)
    {
        $customer= DoctorService::deleteProfilePicture();
        return new InfoResource($customer);
    }

    /**
     * Delete doctor account
     * @param DeleteAccountRequest $request to validate the request data
     * @return SuccessResource
     */
    function deleteAccount(DeleteAccountRequest $request)
    {
        DoctorService::deleteAccount($request->all());
        return new SuccessResource( new stdClass());
    }

    /**
     * Getting all reasons data
     * @return mixed
     */
    function deleteReasonsListing()
    {
        $model = DeleteAccountReason::all();
        return  DeleteAccountReasonResource::collection($model);
    }





}
