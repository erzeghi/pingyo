<?php

namespace PingYo;

class NationalIdentityNumberType
{

    const None = 0;
    const NationalInsurance = 1;

    public static function validation_set()
    {
        return [self::None, self::NationalInsurance];
    }
}