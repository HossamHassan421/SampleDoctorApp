<?php

namespace App\Enum;

class DoctorFeesSettlingType
{
    const doctor = 1;
    const groomer = 2;

    public static function all()
    {
        return [1, 2];
    }

    public static function translate($status)
    {
        switch ($status) {
            case self::doctor:
                return __('doctorFeesSettling.doctor');
            case self::groomer:
                return __('doctorFeesSettling.groomer');
            default:
                return 'Unknown';
        }
    }
}
