<?php

namespace PingYo;

class TitleType
{
    const Mr = 1;
    const Mrs = 2;
    const Ms = 3;
    const Miss = 4;

    public static function validation_set()
    {
        return [self::Mr, self::Mrs, self::Ms, self::Miss];
    }
}