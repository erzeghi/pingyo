<?php

namespace PingYo;

class BankCardTypes
{

    // const AmericanExpress = 1;
    // const Solo = 2;
    // const Visa = 3;
    // const VisaDebit = 4;
    // const VisaDelta = 5;
    // const VisaElectron = 6;
    // const Discover = 7;
    // const MasterCard = 8;
    // const MasterCardDebit = 9;
    // const Laser = 10;
    // const None = 11;
    // const Unknown = 12;


    const Solo = 2;
    const SwitchMaestro = 3;
    const Visa = 4;
    const VisaDebit = 5;
    const VisaDelta = 6;
    const VisaElectron = 7;
    const MasterCard = 9;
    const MasterCardDebit = 10;

    public static function validation_set()
    {
        return [
            // self::AmericanExpress,
            self::Solo,
            self::SwitchMaestro,
            self::Visa,
            self::VisaDebit,
            self::VisaDelta,
            self::VisaElectron,
            self::MasterCard,
            self::MasterCardDebit,

        ];
    }
}