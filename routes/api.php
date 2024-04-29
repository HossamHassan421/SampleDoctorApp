<?php
use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Doctor')->prefix('doctor-app')->group(function () {
    Route::post('login', 'DoctorController@login');
    Route::post('verify-otp', 'DoctorController@verifyOtp');
    Route::post('add-joining-request', 'JoiningRequestController@add');
    Route::get('general-cities-listing', 'DoctorController@getCities');

    //--------------------protected routes-------------------//
    Route::middleware(['auth:api-doctor'])->group(function () {
        //--------------------Doctor-------------------//
        Route::post('update-password', 'DoctorController@updatePassword');
        Route::get('doctor-profile', 'DoctorController@doctorProfile');
        Route::post('doctor-profile-update', 'DoctorController@updateProfile');
        Route::post('doctor-mobile-update', 'DoctorController@updateMobile');
        Route::post('verify-doctor-mobile-update-otp', 'DoctorController@verifyDoctorUpdateMobileOtp');
        Route::post('update-profile-picture', 'DoctorController@updateProfilePicture');
        Route::post('delete-profile-picture', 'DoctorController@deleteProfilePicture');
        Route::post('delete-account', 'DoctorController@deleteAccount');
        Route::get('delete-account-reasons', 'DoctorController@deleteReasonsListing');
    });
});

