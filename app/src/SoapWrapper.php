<?php

namespace Telemetry;

class SoapWrapper
{
    public function __construct()
    {
    }
    public function __desruct()
    {
    }
public function createSoapClient(array $settings): object
{
    $soap_client_handler = false;
    $soap_client_handler = [];
    $exception = '';

    $wsdl = $settings['wsdl'];
    $soap_client_parameter = ['trace' => true, 'exceptions' => true];

    try {
        $soap_client_handle = new \SoapClient($wsdl, $soap_client_handler);
    } catch (\Soap $exception){
        $soap_client_handle = false;
        echo 'Something went wrong';
    }

    return $soap_client_handle;
}

    public function performSoapCall(
        $soap_client_handle,
        $webservice_function,
        $webservice_call_parameters,
        $webservice_value
    )
    {
        $soap_call_result = (object)[];
        $webservice_call_result = null;

        if ($soap_client_handle) {
            try {
                $webservice_call_result = $soap_client_handle->__soapCall(
                    $webservice_function,
                    [$webservice_call_parameters]
                );
                $soap_call_result = $webservice_call_result->{$webservice_value};
            } catch (\SoapFault $exception) {
                $soap_call_result = $exception;
            }
        }

        return $soap_call_result;

}