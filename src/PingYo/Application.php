<?php
namespace PingYo;

class Application
{
    private $region;

    public $affiliateid;
    public $subaffiliate;
    public $campaign;
    public $timeout;
    public $testonly;

    public $useragent;

    private $applicationdetails;
    private $sourcedetails;
    private $connection_status = false;
    private $logger = null;



    private $validation_rules = [
        'required' => [
            [['affiliateid', 'timeout', 'testonly', 'applicationdetails', 'sourcedetails']]
        ],
        'integer' => [
            [['timeout']]
        ],
        'in' => [
            [['testonly'], [false, true]]
        ],
        // 'min' => [
        //     [['timeout'], 45]
        // ],
        // 'max' => [
        //     [['timeout'], 120]
        // ],
        'instanceOf' => [
            // [['applicationdetails'], 'PingYo\ApplicationDetails'],
            [['sourcedetails'], 'PingYo\SourceDetails'],
        ]
    ];

    public function __construct($region = "UK") {
        if (!in_array($region,["USA","UK"])) $region="UK";
        $this->region = $region;
    }

    public function attachLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function setApplicationDetails(ApplicationDetails $applicationdetails)
    {
        if ($this->region != "UK") {
            if (!is_null($this->logger)) {
                $this->logger->warning("Application::setApplicationDetails() called but other region than UK is set.");
            }
            return false;
        }
        if (!is_null($this->logger)) {
            $this->logger->debug("Application::setApplicationDetails() called with applicationdetails=" . var_export($applicationdetails,
                    true));
        }
        $this->applicationdetails = $applicationdetails;
        if (!is_null($this->logger)) {
            $applicationdetails->attachLogger($this->logger);
        }
    }

    public function setApplicationDetailsUSA(ApplicationDetailsUSA $applicationdetails)
    {
        if ($this->region != "USA") {
            if (!is_null($this->logger)) {
                $this->logger->warning("Application::setApplicationDetailsUSA() called but other region is set.");
            }
            return false;
        }
        if (!is_null($this->logger)) {
            $this->logger->debug("Application::setApplicationDetailsUSA() called with applicationdetails=" . var_export($applicationdetails,
                    true));
        }
        $this->applicationdetails = $applicationdetails;
        if (!is_null($this->logger)) {
            $applicationdetails->attachLogger($this->logger);
        }
    }

    public function setSourceDetails(SourceDetails $sourcedetails)
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("Application::setSourceDetails() called with sourcedetails=" . var_export($sourcedetails,
                    true));
        }
        $this->sourcedetails = $sourcedetails;
        if (!is_null($this->logger)) {
            $sourcedetails->attachLogger($this->logger);
        }
    }

    public function get_connection_status()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("Application::get_connection_status() called");
        }
        return $this->connection_status;
    }

    public function send()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("Application::send() called");
        }
        if (is_null($this->useragent)) $this->useragent="";
        $r = $this->validate();
        if ($r === true) {
            $request = $this->toJson();

            if (!is_null($this->logger)) {
                $this->logger->info("request sent: ", array("data"=>$request));
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://leads.pingyo.co.uk/application/submit");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); 
            curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
            curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent); 
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json, text/javascript, *.*',
                'Content-type: application/json; charset=utf-8'
                // 'App-Test-Response-Type: LenderMatchFound'
            ));

            $server_output = curl_exec($ch);
            $info = curl_getinfo($ch);

            if (!is_null($this->logger)) {
                $this->logger->info('API request', array('request'=>curl_getinfo($ch,CURLINFO_HEADER_OUT)));
                $this->logger->info("got response with code " . $info['http_code'] . ': ' . $server_output);
            }

            curl_close($ch);
            $this->connection_status = $info;
            return new Status($info['http_code'], $server_output, null, $this->logger);
        } else {
            return false;
        }
    }

    public function validate($full_validation = true)
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("Application::validate() called with full_validation=$full_validation");
        }

        $validator = new ExtendedValidator(array(
                'campaign' => $this->campaign,
                'affiliateid' => $this->affiliateid,
                'subaffiliate' => $this->subaffiliate,
                'timeout' => $this->timeout,
                'testonly' => $this->testonly,
                'applicationdetails' => $this->applicationdetails,
                'sourcedetails' => $this->sourcedetails
            ));
        $validator->rules($this->validation_rules);
        if ($validator->validate()===true) {
            if ($full_validation) {
                if (($this->applicationdetails->validate()===true) && ($this->sourcedetails->validate()===true)) {
                    if (!is_null($this->logger)) {
                        $this->logger->info("Application validation passed");
                    }
                    return true;
                } else {
                    if (!is_null($this->logger)) {
                        $this->logger->warning("Application validation errors found in child object");
                    }
                    return false;
                }
            } else {
                return true;
            }
        } else {
            if (!is_null($this->logger)) {
                $this->logger->warning("Application validation errors found in main object: ",
                    array('errors' => $validator->errors()));
            }
            return $validator->errors();
        }
    }

    public function toJson()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("Application::toJson() called");
        }
        $r = $this->validate();
        if ($r === true) {
            return json_encode($this->toArray());
        } else {
            return false;
        }
    }

    public function toArray()
    {
        if (!is_null($this->logger)) {
            $this->logger->debug("Application::toArray() called");
        }
        $r = $this->validate();
        if ($r === true) {
            $returnArray = array(
                'AffiliateId' => $this->affiliateid,
                'Timeout' => $this->timeout,
                'TestOnly' => $this->testonly,
                'Application' => $this->applicationdetails->toArray(),
                'SourceDetails' => $this->sourcedetails->toArray()
            );

            if (isset($this->campaign)) $returnArray['Campaign'] = $this->campaign;
            if (isset($this->subaffiliate)) $returnArray['SubAffiliate'] = $this->subaffiliate;
            return $returnArray;

        } else {
            return false;
        }
    }
}