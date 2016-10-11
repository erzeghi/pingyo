<?php

namespace PingYo;

class NationalIdentityNumberTypeUSA
{

    const None = 0;
    const SocialSecurity = 2;

    public static function validation_set()
    {
        return [self::None, self::SocialSecurity];
    }
}