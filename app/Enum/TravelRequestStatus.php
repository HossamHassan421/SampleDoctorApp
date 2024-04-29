<?php

namespace App\Enum;

class TravelRequestStatus
{
    const pending = 1;
    const completed = 2;
    const rejected = 3;

    public static function all()
    {
        return [1, 2, 3];
    }

    public static function translate($status)
    {
        switch ($status) {
            case self::pending:
                return __('travelRequest.pending');
            case self::completed:
                return __('travelRequest.completed');
            case self::rejected:
                return __('travelRequest.rejected');
            default:
                return 'Unknown';
        }
    }
}
