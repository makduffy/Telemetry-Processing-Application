<?php
declare (strict_types=1);

namespace Telemetry\models;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class TelemetryDetailModel

{
    private $logger;
    private $entityManager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function __destruct()
    {
    }

    public function callTelemetryData($soap_wrapper, $settings): array
    {
        $this->logger->info("Initiating call to telemetry data.");

        $M2MDetails = $settings['M2M_Details'];

        $username = $M2MDetails['username'];
        $password = $M2MDetails['password'];
        $count = $M2MDetails['count'];
        $deviceMSISDN = $M2MDetails['deviceMSISDN'];
        $countryCode = $M2MDetails['countryCode'];

        $webservice_call_parameters = [
            'username' => $username,
            'password' => $password,
            'count' => $count,
            'deviceMSISDN' => $deviceMSISDN,
            'countryCode' => $countryCode,
        ];
        $webservice_function = 'peekMessages';
        $soap_client_handle = $soap_wrapper->createSoapClient($settings);

        $result = $soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_call_parameters);
        $this->logger->info("Telemetry data call completed successfully.");
        return $result;
    }
    public function storeTelemetryData($fanData, $heaterData, $switch1Data, $switch2Data, $switch3Data, $switch4Data, $keypadData): void
    {
        $telemetryData = new TelemetryData();

        $telemetryData->setFanData($fanData);

        if ($heaterData !== null) {
            $telemetryData->setHeaterData($heaterData);
        }

        if ($switch1Data !== null) {
            $telemetryData->setSwitch1Data($switch1Data);
        }

        if ($switch2Data !== null) {
            $telemetryData->setSwitch2Data($switch2Data);
        }

        if ($switch3Data !== null) {
            $telemetryData->setSwitch3Data($switch3Data);
        }

        if ($switch4Data !== null) {
            $telemetryData->setSwitch4Data($switch4Data);
        }

        if ($keypadData !== null) {
            $telemetryData->setKeypadData($keypadData);
        }

        $this->entityManager->persist($telemetryData);
        $this->entityManager->flush();
    }


}

