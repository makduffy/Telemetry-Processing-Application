<?php


declare (strict_types=1);

namespace Telemetry\models;

use Psr\Log\LoggerInterface;

class TelemetryDetailModel

{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __destruct()
    {
    }

    public function callTelemetryData($soap_wrapper, $settings): array
    {
        $this->logger->info("Initiating call to telemetry data.");

        $username = '23_2635754';
        $password = 'DoorDash!!12';
        $count = 25;
        $deviceMSISDN = '+447452835992';
        $countryCode = '+44';

        $webservice_call_parameters = [
            'username' => $username,
            'password' => $password,
            'count' => $count,
            'deviceMSISDN' => $deviceMSISDN,
            'countryCode' => $countryCode,
        ];
        $webservice_function = ('peekMessages');
        $soap_client_handle = $soap_wrapper->createSoapClient($settings);

        $result =  $soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_call_parameters);
        $this->logger->info("Telemetry data call completed successfully.");
        return $result;
    }

}

