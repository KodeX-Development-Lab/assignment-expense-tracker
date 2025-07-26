<?php

namespace App;

class MoneyFormatter 
{
    public static function format_money($amount, $currency = 'MMK')
    {
        return number_format($amount, 0) . ' ' . $currency;
    }
}