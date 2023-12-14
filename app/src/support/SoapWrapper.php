<?php

namespace Telemetry\Support;

class SoapWrapper


{
    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function createSoapClient($settings): object
    {

        $soap_client_parameters = ['trace' => true, 'exceptions' => true];
        $wsdl = $settings['wsdl'];
        try {
            $soap_client_handle = new \SoapClient($wsdl, $soap_client_parameters);
        } catch (\SoapFault $exception) {
            $soap_client_handle = false;
            echo 'Soap Client creation was unsuccessful';
        }
        return $soap_client_handle;
    }

    public function performSoapCall($soap_client_handle, $soap_function, $webservice_call_parameters)
    {
        return $soap_client_handle->__soapCall($soap_function, $webservice_call_parameters);
    }
}