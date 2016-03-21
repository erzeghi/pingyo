<?php
namespace PingYo;

class ApplicationDetails
{

    public $title;
    public $firstname;
    public $lastname;
    public $dateofbirth;
    public $email;
    public $homephonenumber;
    public $mobilephonenumber;
    public $workphonenumber;
    public $employername;
    public $jobtitle;
    public $employmentstarted;
    public $employerindustry;
    public $incomesource;
    public $payfrequency;
    public $payamount;
    public $incomepaymenttype;
    public $nextpaydate;
    public $followingpaydate;
    public $loanamount;
    public $nationalidentitynumber;
    public $nationalidentitynumbertype;
    public $consenttocreditsearch;
    public $consenttomarketingemails;
    public $residentialstatus;
    public $housenumber;
    public $housename;
    public $addressstreet1;
    public $addresscity;
    public $addresscounty;
    public $addressmovein;
    public $addresspostcode;
    public $bankaccountnumber;
    public $bankcardtype;
    public $bankroutingnumber;
    public $monthlymortgagerent;
    public $monthlycreditcommitments;
    public $otherexpenses;
    public $minimumcommissionamount;
    public $maximumcommissionamount;
    public $applicationextensions;
    public $usesonlinebanking;
    public $term;
    public $transport;
    public $food;
    public $utilities;
    public $confirmedbyapplicant;
    public $maritalstatus;
    public $loanproceeduse;
    public $numberofdependents;
    public $combinedmonthlyhouseholdincome;


    private $logger = null;

    private $boolean_variants = [false, true];

    public function attachLogger(\Psr\Log\LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    public function toJson()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("ApplicationDetails::toJson() called");
        }
        $r = $this->validate();
        if ($r === true) {
            return json_encode($this->toArray());
        }
    }

    public function validate()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("ApplicationDetails::validate() called");
        }

        if ($this->employername == "") $this->employername = "unemployed";

        $validator = new ExtendedValidator(array(
            'title' => $this->title,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'dateofbirth' => $this->dateofbirth,
            'email' => $this->email,
            'homephonenumber' => $this->homephonenumber,
            'mobilephonenumber' => $this->mobilephonenumber,
            'workphonenumber' => $this->workphonenumber,
            'employername' => $this->employername,
            'jobtitle' => $this->jobtitle,
            'employmentstarted' => $this->employmentstarted,
            'employerindustry' => $this->employerindustry,
            'incomesource' => $this->incomesource,
            'payfrequency' => $this->payfrequency,
            'payamount' => $this->payamount,
            'incomepaymenttype' => $this->incomepaymenttype,
            'nextpaydate' => $this->nextpaydate,
            'followingpaydate' => $this->followingpaydate,
            'loanamount' => $this->loanamount,
            'nationalidentitynumber' => $this->nationalidentitynumber,
            'nationalidentitynumbertype' => $this->nationalidentitynumbertype,
            'consenttocreditsearch' => $this->consenttocreditsearch,
            'consenttomarketingemails' => $this->consenttomarketingemails,
            'residentialstatus' => $this->residentialstatus,
            'housenumber' => $this->housenumber,
            'housename' => $this->housename,
            'addressstreet1' => $this->addressstreet1,
            'addresscity' => $this->addresscity,
            'addresscounty' => $this->addresscounty,
            'addressmovein' => $this->addressmovein,
            'addresspostcode' => $this->addresspostcode,
            'bankaccountnumber' => $this->bankaccountnumber,
            'bankcardtype' => $this->bankcardtype,
            'bankroutingnumber' => $this->bankroutingnumber,
            'monthlymortgagerent' => $this->monthlymortgagerent,
            'monthlycreditcommitments' => $this->monthlycreditcommitments,
            'otherexpenses' => $this->otherexpenses,
            'minimumcommissionamount' => $this->minimumcommissionamount,
            'maximumcommissionamount' => $this->maximumcommissionamount,
            'applicationextensions' => $this->applicationextensions,
            'usesonlinebanking' => $this->usesonlinebanking,
            'term' => $this->term,
            'transport' => $this->transport,
            'food' => $this->food,
            'utilities' => $this->utilities,
            'confirmedbyapplicant' => $this->confirmedbyapplicant,
            'maritalstatus' => $this->maritalstatus,
            'loanproceeduse' => $this->loanproceeduse,
            'numberofdependents' => $this->numberofdependents,
            'combinedmonthlyhouseholdincome' => $this->combinedmonthlyhouseholdincome
        ));
        $validator->rules($this->getValidationRules());

        //custom messages
        $validator->rule('not_on_weekend', array('nextpaydate', 'followingpaydate'))->message('{field} cannot be Saturday or Sunday');
        $validator->rule('only_digits', array('mobilephonenumber','homephonenumber','workphonenumber'))->message('{field} should only contain digits 0-9');
        $startwith = '07';
        $validator->rule('start_with_string', array('mobilephonenumber'),$startwith)->message('{field} should start with '.$startwith);

        if ($validator->validate()) {
            if (!is_null($this->logger)) {
                $this->logger->info("ApplicationDetails validation passed");
            }
            return true;
        } else {
            if (!is_null($this->logger)) {
                $this->logger->warning("ApplicationDetails validation errors found: ",
                    array('errors' => $validator->errors()));
            }
            return $validator->errors();
        }
    }

    private function getValidationRules()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("ApplicationDetails::getValidationRules() called");
        }
        return [
            'required' => [
                [
                    [
                        'title',
                        'firstname',
                        'lastname',
                        'dateofbirth',
                        'email',
                        'homephonenumber',
                        'mobilephonenumber',
                        'workphonenumber',
                        'employername',
                        'employmentstarted',
                        'employerindustry',
                        'incomesource',
                        'payfrequency',
                        'payamount',
                        'incomepaymenttype',
                        'nextpaydate',
                        'followingpaydate',
                        'loanamount',
                        'nationalidentitynumbertype',
                        'consenttocreditsearch',
                        'consenttomarketingemails',
                        'residentialstatus',
                        'addressstreet1',
                        'addresscity',
                        'addresscounty',
                        'addressmovein',
                        'addresspostcode',
                        'bankaccountnumber',
                        'bankcardtype',
                        'bankroutingnumber',
                        'monthlymortgagerent',
                        'monthlycreditcommitments',
                        'otherexpenses',
                        'term',
                        'transport',
                        'food',
                        'utilities',
                        'confirmedbyapplicant',
                        'maritalstatus',
                        'loanproceeduse',
                        'numberofdependents',
                    ]
                ]
            ],
            'required_without' => [
                [['housenumber'], 'housename'],
                [['housename'], 'housenumber']
            ],
            'required_if' => [
                // [['nationalidentitynumber'], ['bankcardtype', ['None', 'Unknown']]],
                [['combinedmonthlyhouseholdincome'], ['maritalstatus', [MaritalStatusType::Married]]]
            ],
            'email' => [
                [['email']]
            ],
            'length' => [
                [['mobilephonenumber'],11]
            ],
            'lengthBetween' => [
                [['homephonenumber','workphonenumber'],10,11]
            ],
            'lengthMin' => [
                [['firstname', 'lastname'], 2],
                [['employername'], 1],
            ],
            'date' => [
                [['dateofbirth', 'employmentstarted', 'nextpaydate', 'followingpaydate', 'addressmovein']]
            ],
            'dateAfter' => [
                [['nextpaydate'], $this->getTodayDate()],
                [['followingpaydate'], $this->getNextPAYDATE()],
            ],
            'dateBefore' => [
                [['nextpaydate'], $this->getValidPAYDATE()],
                [['followingpaydate'], $this->getValidFollowingPAYDATE()],
                [['dateofbirth'], $this->getValidDOB()]
            ],
            'in' => [
                [['title'], TitleType::validation_set()],
                [['employerindustry'], EmployerIndustryType::validation_set()],
                [['incomesource'], IncomeSourceType::validation_set()],
                [['payfrequency'], PayFrequencyType::validation_set()],
                [['incomepaymenttype'], IncomePaymentType::validation_set()],
                [['nationalidentitynumbertype'], NationalIdentityNumberType::validation_set()],
                [['residentialstatus'], ResidentialStatusType::validation_set()],
                [['consenttomarketingemails', 'confirmedbyapplicant','usesonlinebanking'], $this->boolean_variants],
                [['bankcardtype'], BankCardType::validation_set()],
                [['maritalstatus'], MaritalStatusType::validation_set()],
                [['loanproceeduse'], LoanProceedUseType::validation_set()],
            ],
            'accepted'=> [
                [['consenttocreditsearch']],
            ],
            'integer' => [
                [['payamount','loanamount','term','numberofdependents']]
            ],
            'min' => [
                [['payamount'], 0]
            ],
            'max' => [
                [['payamount'], 15000]
            ],
            'numeric' => [
                [
                    [
                        'monthlymortgagerent',
                        'monthlycreditcommitments',
                        'otherexpenses',
                        'minimumcommissionamount',
                        'maximumcommissionamount',
                        'transport',
                        'food',
                        'utilities'
                    ]
                ]
            ],
            'array' => [
                [['applicationextensions']]
            ]
        ];
    }

    private function getTodayDate()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("ApplicationDetails::getTodayDate() called");
        }
        $date = new \DateTime("now", new \DateTimeZone("UTC"));
        return $date;
    }

    private function getNextPAYDATE()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("ApplicationDetails::getNextPAYDATE() called");
        }
        $date = new \DateTime($this->nextpaydate, new \DateTimeZone("UTC"));
        return $date;
    }

    private function getValidPAYDATE()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("ApplicationDetails::getValidPAYDATE() called");
        }
        $date = new \DateTime("now", new \DateTimeZone("UTC"));
        $date->add(date_interval_create_from_date_string('45 days'));
        return $date;
    }

    private function getValidFollowingPAYDATE()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("ApplicationDetails::getFollowingPAYDATE() called");
        }
        $date = new \DateTime($this->nextpaydate, new \DateTimeZone("UTC"));
        $date->add(date_interval_create_from_date_string('45 days'));
        return $date;
    }

    private function getValidDOB()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("ApplicationDetails::getValidDOB() called");
        }
        $date = new \DateTime("now", new \DateTimeZone("UTC"));
        $date->sub(date_interval_create_from_date_string('18 years'));
        return $date;
    }

    public function toArray()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("ApplicationDetails::toArray() called");
        }
        $r = $this->validate();
        if ($r === true) {
            $returnArray = array(
                'Title' => $this->title,
                'FirstName' => $this->firstname,
                'LastName' => $this->lastname,
                'DateOfBirth' => $this->strDateToJsonDate($this->dateofbirth),
                'Email' => $this->email,
                'HomePhoneNumber' => $this->homephonenumber,
                'MobilePhoneNumber' => $this->mobilephonenumber,
                'WorkPhoneNumber' => $this->workphonenumber,
                'EmployerName' => $this->employername,
                'EmploymentStarted' => $this->strDateToJsonDate($this->employmentstarted),
                'EmployerIndustry' => $this->employerindustry,
                'IncomeSource' => $this->incomesource,
                'PayFrequency' => $this->payfrequency,
                'PayAmount' => $this->payamount,
                'IncomePaymentType' => $this->incomepaymenttype,
                'NextPayDate' => $this->strDateToJsonDate($this->nextpaydate),
                'FollowingPayDate' => $this->strDateToJsonDate($this->followingpaydate),
                'LoanAmount' => $this->loanamount,
                'NationalIdentityNumberType' => $this->nationalidentitynumbertype,
                'ConsentToCreditSearch' => $this->consenttocreditsearch,
                'ConsentToMarketingEmails' => $this->consenttomarketingemails,
                'ResidentialStatus' => $this->residentialstatus,
                'HouseNumber' => $this->housenumber,
                'HouseName' => $this->housename,
                'AddressStreet1' => $this->addressstreet1,
                'AddressCity' => $this->addresscity,
                'AddressCounty' => $this->addresscounty,
                'AddressMoveIn' => $this->strDateToJsonDate($this->addressmovein),
                'AddressPostcode' => $this->addresspostcode,
                'BankAccountNumber' => $this->bankaccountnumber,
                'BankCardType' => $this->bankcardtype,
                'BankRoutingNumber' => $this->bankroutingnumber,
                'MonthlyMortgageRent' => $this->monthlymortgagerent,
                'MonthlyCreditCommitments' => $this->monthlycreditcommitments,
                'OtherExpenses' => $this->otherexpenses,
                'Term' => $this->term,
                'Transport' => $this->transport,
                'Food' => $this->food,
                'Utilities' => $this->utilities,
                'ConfirmedByApplicant' => $this->confirmedbyapplicant,
                'MaritalStatus' => $this->maritalstatus,
                'LoanProceedUse' => $this->loanproceeduse,
                'NumberOfDependents' => $this->numberofdependents,
                'CombinedMonthlyHouseholdIncome' => $this->combinedmonthlyhouseholdincome
            );
            
            //nonrequired fields
            if (isset($this->jobtitle)) $returnArray['JobTitle'] = $this->jobtitle; 
            if (isset($this->nationalidentitynumber)) $returnArray['NationalIdentityNumber'] = $this->nationalidentitynumber; 
            if (isset($this->usesonlinebanking)) $returnArray['UsesOnlineBanking'] = $this->usesonlinebanking; 
            if (isset($this->minimumcommissionamount)) $returnArray['MinimumCommissionAmount'] = $this->minimumcommissionamount; 
            if (isset($this->maximumcommissionamount)) $returnArray['MaximumCommissionAmount'] = $this->maximumcommissionamount; 
            if (isset($this->applicationextensions)) $returnArray['ApplicationExtensions'] = $this->applicationextensions; 

            return $returnArray;
        }
    }

    private function strDateToJsonDate($strdate)
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("ApplicationDetails::strDateToJsonDate() called with strdate=$strdate");
        }
        $date = new \DateTime($strdate, new \DateTimeZone("UTC"));
        return '/Date(' . ($date->getTimestamp() * 1000) . ')/';
    }

    private function NormalizePhone($phone, $country)
    {

        return $phone;


        if (!is_null($this->logger)) {
            $this->logger->debug("ApplicationDetails::NormalizePhone() called with phone=$phone and country=$country");
        }
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $swissNumberProto = $phoneUtil->parse($phone, $country);
        //PhoneNumberFormat::NATIONAL or PhoneNumberFormat::INTERNATIONAL
        return $phoneUtil->format($swissNumberProto, \libphonenumber\PhoneNumberFormat::NATIONAL);
    }

}