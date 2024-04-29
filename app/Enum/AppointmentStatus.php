<?php

namespace App\Enum;

class AppointmentStatus
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

    public static function translate($status, $type = AppointmentType::health)
    {
        switch ($status) {
            case self::pending:
                return __('appointment.pending');
            case self::doctorAssigned:
                if($type == AppointmentType::grooming) {
                    return __('appointment.groomerAssigned');
                } else {
                    return __('appointment.doctorAssigned');
                }
            case self::finished:
                return __('appointment.finished');
            case self::cancelled:
                return __('appointment.cancelled');
            case self::started:
                return __('appointment.started');
            default:
                return 'Unknown';
        }
    }
}
