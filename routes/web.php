<?php
use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers')->middleware(['web', 'auth:admins'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    //--------------------Doctor-------------------//
    Route::get('doctor', 'DoctorController@listing')->name('doctor-listing')->middleware('can:doctor-access');
    Route::get('doctor/create', 'DoctorController@create')->name('doctor-create')->middleware('can:doctor-add');
    Route::post('doctor/add', 'DoctorController@add')->name('doctor-add')->middleware('can:doctor-add');
    Route::get('doctor/edit/{uuid}', 'DoctorController@edit')->name('doctor-edit')->middleware('can:doctor-edit');
    Route::post('doctor/update', 'DoctorController@update')->name('doctor-update')->middleware('can:doctor-edit');
    Route::post('doctor/activation-toggle', 'DoctorController@activationToggle')->name('doctor-activation-toggle')->middleware('can:doctor-activation-toggle');
    Route::post('doctor/show/{uuid}', 'DoctorController@show')->name('doctor-show')->middleware('can:doctor-show');
    Route::post('doctor-schedule-type-show', 'DoctorController@doctorScheduleTypeShow')->name('doctor-schedule-type-show')->middleware('can:doctor-add');
    Route::post('doctor/change-password', 'DoctorController@changePassword')->name('doctor-change-password')->middleware('can:doctor-change-password');
    Route::get('doctor/reset-password/{uuid}', 'DoctorController@resetPassword')->name('doctor-reset-password')->middleware('can:doctor-reset-password');
    Route::post('doctor/download-excel', 'DoctorController@downloadExcel')->name('doctor-download-excel')->middleware('can:doctor-download-excel');
});

