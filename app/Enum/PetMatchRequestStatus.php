<?php

namespace App\Enum;

class PetMatchRequestStatus
{
    const pending = 1;
    const completed = 2;
    const rejected = 3;
    const cancelled = 4;

    public static function all()
    {
        return [1, 2, 3, 4];
    }

    public static function translate($status)
    {
        switch ($status) {
            case self::pending:
                return __('petMatchRequest.pending');
            case self::completed:
                return __('petMatchRequest.completed');
            case self::rejected:
                return __('petMatchRequest.rejected');
            case self::cancelled:
                return __('petMatchRequest.cancelled');
            default:
                return 'Unknown';
        }
    }
}
