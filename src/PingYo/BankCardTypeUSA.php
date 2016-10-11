<?php

namespace PingYo;

class BankCardTypeUSA
{

    const AmericanExpress = 1;
    const Solo = 2;
    const SwitchMaestro = 3;
    const Visa = 4;
    const VisaDebit = 5;
    const VisaDelta = 6;
    const VisaElectron = 7;
    const Discover = 8;
    const MasterCard = 9;
    const MasterCardDebit = 10;
    const Laser = 11;

    public static function validation_set()
    {
        return [
            self::AmericanExpress,
            self::Solo,
            self::SwitchMaestro,
            self::Visa,
            self::VisaDebit,
            self::VisaDelta,
            self::VisaElectron,
            self::Discover,
            self::MasterCard,
            self::MasterCardDebit,
            self::Laser
        ];
    }
}