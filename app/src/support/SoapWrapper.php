<?php

namespace Telemetry\Support;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class SoapWrapper
 *
 * A wrapper class for handling SOAP client creation and performing SOAP calls.
 *
 */

class SoapWrapper   {
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
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
            $this->logger->info("SOAP client created successfully.");
        } catch (\SoapFault $exception) {
            $soap_client_handle = false;
            $this->logger->error("Soap Client creation was unsuccessful: " . $exception->getMessage());
        }


        return $soap_client_handle;
    }

    public function performSoapCall($soap_client_handle, $soap_function, $webservice_call_parameters)
    {
        try {
            $response = $soap_client_handle->__soapCall($soap_function, $webservice_call_parameters);
            $this->logger->info("SOAP call performed successfully.");
            return $response;
        } catch (\SoapFault $exception) {
            $this->logger->error("SOAP call failed: " . $exception->getMessage());
            return null;
        }
    }
}