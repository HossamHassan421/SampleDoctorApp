<?php

namespace App\Enum;

class TransactionType
{
    const health = 1;
    const grooming = 2;
    const emergency = 3;
    const travelServices = 4;
    const travelRequests = 5;
    const cashSupplying = 6;
    const doctorFeesSettling = 7;
    const boardingRequests = 8;
    const boardingRequestDetails = 9;

    public static function all()
    {
        return [1, 2, 3, 4, 5, 6, 7, 8, 9];
    }

    public static function translate($status)
    {
        switch ($status) {
            case self::health:
                return __('transaction.health');
            case self::grooming:
                return __('transaction.grooming');
            case self::emergency:
                return __('transaction.emergency');
            case self::travelServices:
                return __('transaction.travelServices');
            case self::travelRequests:
                return __('transaction.travelRequests');
            case self::cashSupplying:
                return __('transaction.cashSupplying');
            case self::doctorFeesSettling:
                return __('transaction.doctorFeesSettling');
            case self::boardingRequests:
                return __('common.boardingRequests');
            case self::boardingRequestDetails:
                return __('common.boardingRequestDetails');
            default:
                return 'Unknown';
        }
    }

    public static function badgeClass($status)
    {
        switch ($status) {
            case self::health:
                return 'primary';
            case self::grooming:
                return 'info';
            case self::emergency:
                return 'warning';
            case self::travelServices:
                return 'success';
            case self::travelRequests:
                return 'secondary';
            case self::cashSupplying:
                return 'danger';
            case self::doctorFeesSettling:
                return 'dark';
            case self::boardingRequests:
                return 'success';
            case self::boardingRequestDetails:
                return 'danger';
            default:
                return 'Unknown';
        }
    }
}
