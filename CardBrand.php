<?php

namespace App\Classes;


class CardBrand {

    // Date source: https://www.bincodes.com/bin-list/,
    // Last updated: Sept. 2, 2023
    private static $brands = [
        'amex' => 'American Express',
        'unionpay' => 'China UnionPay',
        'diners' => 'Diners Club',
        'discover' => 'Discover Card',
        'interpayment' => 'InterPayment',
        'instapayment' => 'InstaPayment',
        'jcb' => 'JCB',
        'maestro' => 'Maestro',
        'mc' => 'MasterCard',
        'visa' => 'Visa',
        'uatp' => 'UATP',
    ];

    private static $binMap = [
        ['len' => 1, 'from' => 1, 'to' => 1, 'code' => 'uatp'],
        ['len' => 4, 'from' => 2221, 'to' => 2720, 'code' => 'mc'],
        ['len' => 3, 'from' => 300, 'to' => 305, 'code' => 'diners'],
        ['len' => 2, 'from' => 34, 'to' => 34, 'code' => 'amex'],
        ['len' => 4, 'from' => 3528, 'to' => 3589, 'code' => 'jcb'],
        ['len' => 2, 'from' => 36, 'to' => 36, 'code' => 'diners'],
        ['len' => 2, 'from' => 37, 'to' => 37, 'code' => 'amex'],
        ['len' => 1, 'from' => 4, 'to' => 4, 'code' => 'visa'],
        ['len' => 2, 'from' => 50, 'to' => 50, 'code' => 'maestro'],

        // next 2 overlaps, more specific is on top
        ['len' => 2, 'from' => 54, 'to' => 55, 'code' => 'diners'],
        ['len' => 2, 'from' => 51, 'to' => 55, 'code' => 'mc'],

        ['len' => 2, 'from' => 56, 'to' => 58, 'code' => 'maestro'],
        ['len' => 4, 'from' => 6011, 'to' => 6011, 'code' => 'discover'],

        // the rest of the list overlaps, ordered to return more specific results first
        ['len' => 6, 'from' => 622126, 'to' => 622925, 'code' => 'discover'],
        ['len' => 2, 'from' => 62, 'to' => 62, 'code' => 'unionpay'],
        ['len' => 3, 'from' => 636, 'to' => 636, 'code' => 'interpayment'],
        ['len' => 3, 'from' => 637, 'to' => 639, 'code' => 'instapayment'],
        ['len' => 3, 'from' => 644, 'to' => 649, 'code' => 'discover'],
        ['len' => 2, 'from' => 65, 'to' => 65, 'code' => 'discover'],
        ['len' => 1, 'from' => 6, 'to' => 6, 'code' => 'maestro'],
    ];

    public static function find(string $cardNumber) {
        $cardNumber = preg_replace('/[^0-9]/', '', $cardNumber);
        foreach (self::$binMap as $code => $rule) {
            $prefix = intval(substr($cardNumber, 0, $rule['len']));
            if ($prefix >= $rule['from'] && $prefix <= $rule['to']) {
                return ['code' => $rule['code'], 'brand' => self::$brands[$rule['code']]];
            }
        }
    }

}
