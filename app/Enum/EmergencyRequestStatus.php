<?php

namespace App\Enum;

class EmergencyRequestStatus
{
    const pending = 1;
    const doctorAssigned = 2;
    const finished = 3;
    const cancelled = 4;
    const started = 5;

    public static function all()
    {
        return [1, 2, 3, 4, 5];
    }

    public static function translate($status)
    {
        switch ($status) {
            case self::pending:
                return __('emergencyRequest.pending');
            case self::doctorAssigned:
                return __('emergencyRequest.doctorAssigned');
            case self::finished:
                return __('emergencyRequest.finished');
            case self::cancelled:
                return __('emergencyRequest.cancelled');
            case self::started:
                return __('emergencyRequest.started');
            default:
                return 'Unknown';
        }
    }
}
