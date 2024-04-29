<?php

namespace App\Enum;

class BoardingRequestStatus
{
    const pending = 0;
    const paid = 1;
    const declined = 2;

    public static function all()
    {
        return [0, 1, 2];
    }

    public static function translate($status)
    {
        switch ($status) {
            case self::pending:
                return __('common.pending');
            case self::paid:
                return __('common.completed');
            case self::declined:
                return __('common.cancelled');
            default:
                return 'Unknown';
        }
    }
}
