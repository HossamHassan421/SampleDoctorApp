<?php

namespace App\Providers;

use App\Enum\AppointmentStatus;
use App\Enum\AppointmentType;
use App\Enum\TravelStatus;
use App\Services\AppointmentService;
use App\Services\JoiningRequestService;
use App\Services\TravelRequestService;
use App\Services\TravelService;
use Doctrine\DBAL\Types\Type;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!Type::hasType('tinyinteger')) {
            // Register the custom type
            Type::addType('tinyinteger', \Doctrine\DBAL\Types\SmallIntType::class);
        }

        View::composer('layouts.notifications', function ($view) {
//            $visitsTodayPending = AppointmentService::getBy([
//                'date' => date('Y-m-d'),
//                'status' => AppointmentStatus::pending,
//                'getCount' => true
//            ]);
//            $view->with('visitsTodayPending', $visitsTodayPending);
            ///////////////////////////////////////////////
            $visitsPending = AppointmentService::getBy([
                'from_date' => date('Y-m-d'),
                'status' => AppointmentStatus::pending,
                'getCount' => true
            ], AppointmentType::health);
            $view->with('visitsPending', $visitsPending);
            ///////////////////////////////////////////////
            $visitsGroomingPending = AppointmentService::getBy([
                'from_date' => date('Y-m-d'),
                'status' => AppointmentStatus::pending,
                'getCount' => true
            ], AppointmentType::grooming);
            $view->with('visitsGroomingPending', $visitsGroomingPending);
            ///////////////////////////////////////////////
            $travelPending = TravelService::getBy([
                'status' => TravelStatus::pending,
                'getCount' => true
            ]);
            $view->with('travelPending', $travelPending);
            ///////////////////////////////////////////////
            $travelRequestPending = TravelRequestService::getBy([
                'status' => TravelStatus::pending,
                'getCount' => true
            ]);
            $view->with('travelRequestPending', $travelRequestPending);
            ///////////////////////////////////////////////
            $joiningRequestPending = JoiningRequestService::getBy([
                'status' => TravelStatus::pending,
                'getCount' => true
            ]);
            $view->with('joiningRequestPending', $joiningRequestPending);
        });
    }
}
