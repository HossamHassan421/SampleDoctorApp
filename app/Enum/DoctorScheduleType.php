<?php

namespace App\Enum;

class DoctorScheduleType
{
    const doctor = 1;
    const groomer = 2;

    public static function translate($status)
    {
        switch ($status) {
            case self::doctor:
                return __('doctor.doctor');
            case self::groomer:
                return __('doctor.groomer');
        }
    }
}
