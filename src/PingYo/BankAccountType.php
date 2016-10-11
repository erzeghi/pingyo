<?php

namespace PingYo;

class BankAccountType
{
    
    const Checking = 1;
    const Savings = 2;

    public static function validation_set()
    {
        return [
            self::Checking,
            self::Savings
        ];
    }
}