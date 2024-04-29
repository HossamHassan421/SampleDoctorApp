<?php

namespace App\Enum;

class CashSupplyingType
{
    const doctor = 1;
    const groomer = 2;

    public static function translate($status)
    {
        switch ($status) {
            case self::doctor:
                return __('cashSupplying.doctor');
            case self::groomer:
                return __('cashSupplying.groomer');
        }
    }
}
