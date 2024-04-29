<?php

namespace App\Enum;

class AppointmentType
{
    const health = 1;
    const grooming = 2;

    public static function translate($status)
    {
        switch ($status) {
            case self::health:
                return __('appointment.health_request');
            case self::grooming:
                return __('appointment.grooming_request');
        }
    }
}
