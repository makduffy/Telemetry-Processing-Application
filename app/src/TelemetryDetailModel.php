<?php


declare (strict_types=1);

namespace Telemetry;
class TelemetryDetailModel
{
    private $receive;

    public function __construct()
    {
        $this->receive = '';
    }

    public function __destruct(){}

    public function setParameters($cleaned_parameters){
        $this->receive = $cleaned_parameters[''];
    }

    public function getSMSDetail($username, $password, $msisdn)
    {
        

    }



}