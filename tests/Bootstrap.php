<?php

error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure that composer has installed all dependencies
if (!file_exists(dirname(__DIR__) . '/composer.lock')) {
    die("Dependencies must be installed using composer:\n\nphp composer.phar install --dev\n\n"
        . "See http://getcomposer.org for help with installing composer\n");
}

$root = realpath(dirname(dirname(__FILE__)));
$library = "$root/src";

$path = array($library, get_include_path());
set_include_path(implode(PATH_SEPARATOR, $path));

require_once 'PingYo/Application.php';
require_once 'PingYo/SourceDetails.php';
require_once 'PingYo/ApplicationDetails.php';
require_once 'PingYo/ApplicationDetailsUSA.php';
require_once 'PingYo/Status.php';

require_once 'PingYo/TitlesType.php';
require_once 'PingYo/BankCardType.php';
require_once 'PingYo/BankCardTypeUSA.php';
require_once 'PingYo/ResidentialStatusType.php';
require_once 'PingYo/IncomePaymentType.php';
require_once 'PingYo/PayFrequencyType.php';
require_once 'PingYo/IncomeSourceType.php';
require_once 'PingYo/EmployerIndustryType.php';
require_once 'PingYo/NationalIdentityNumberType.php';
require_once 'PingYo/NationalIdentityNumberTypeUSA.php';
require_once 'PingYo/MaritalStatusType.php';
require_once 'PingYo/LoanProceedUseType.php';
require_once 'PingYo/MilitaryServiceType.php';
require_once 'PingYo/BankAccountType.php';
require_once 'PingYo/USStates.php';

// Include the composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

require_once 'PingYo/ExtendedValidator.php';

unset($root, $library, $path);