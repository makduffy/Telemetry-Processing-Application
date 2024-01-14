<?php

namespace Telemetry\Models;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class PostMessageModel
{

    private $logger;
    private $entity_manager;
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entity_manager)
    {
        $this->logger = $logger;
        $this->entity_manager = $entity_manager;
    }

    public function sendMessage($soap_wrapper, $settings, $message)
    {
        $this->logger->info("Initiating call to telemetry data.");

        $M2MDetails = $settings['M2M_Details'];

        $username = $M2MDetails['username'];
        $password = $M2MDetails['password'];
        $count = $M2MDetails['count'];
        $deviceMSISDN = $M2MDetails['M2MNumber'];
        $countryCode = $M2MDetails['countryCode'];

        $webservice_call_parameters = [
            'username' => $username,
            'password' => $password,
            'count' => $count,
            'deviceMSISDN' => $deviceMSISDN,
            'countryCode' => $countryCode,
            'message' => $message
        ];
        $webservice_function = 'sendMessages';
        $soap_client_handle = $soap_wrapper->createSoapClient($settings);

        $result = $soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_call_parameters);
        $this->logger->info("Telemetry data call completed successfully.");
        return $result;
    }
}