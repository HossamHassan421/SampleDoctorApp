<?php

namespace App\Enum;

class DoctorFeesSettlingStatus
{
    const pending = 1;
    const paid = 2;

    public static function all()
    {
        return [1, 2];
    }

    public static function translate($status)
    {
        switch ($status) {
            case self::pending:
                return __('doctorFeesSettling.pending');
            case self::paid:
                return __('doctorFeesSettling.paid');
            default:
                return 'Unknown';
        }
    }
}
