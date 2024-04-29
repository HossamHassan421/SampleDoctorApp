<?php

namespace App\Enum;

class JoiningRequestStatus
{
    const pending = 1;
    const accepted = 2;
    const rejected = 3;

    public static function all()
    {
        return [1, 2, 3];
    }

    public static function translate($status)
    {
        switch ($status) {
            case self::pending:
                return __('joiningRequest.pending');
            case self::accepted:
                return __('joiningRequest.accepted');
            case self::rejected:
                return __('joiningRequest.rejected');
            default:
                return 'Unknown';
        }
    }
}
