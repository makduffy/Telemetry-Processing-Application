<?php


declare (strict_types=1);

namespace Telemetry\models;
class
TelemetryDetailModel

{

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function retrieveData($soap_wrapper, $settings): array
    {
        $username = '23_2635754';
        $password = 'DoorDash!!12';
        $count = 4;
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

        return $soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_call_parameters);

    }

    public function parseData(){

    }
}