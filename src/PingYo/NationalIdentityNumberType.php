<?php

namespace PingYo;

class NationalIdentityNumberType
{

    const None = 0;
    const NationalInsurance = 1;
    const SocialSecurity = 2;

    public static function validation_set()
    {
        return [self::None, self::NationalInsurance, self::SocialSecurity];
    }
}