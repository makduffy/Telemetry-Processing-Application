<?php
declare (strict_types=1);

namespace Telemetry\models;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Telemetry\Models\MessageDetailModel;

class TelemetryDetailModel
{
    private $logger;
    private $entity_manager;
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entity_manager)
    {
        $this->logger = $logger;
        $this->entity_manager = $entity_manager;
    }
    public function __destruct(){}

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
    public function storeTelemetryData($fanData, $heater_data, $switch1_data, $switch2_data, $switch3_data, $switch4_data, $keypad_data): void {
        $telemetry_data = new TelemetryData();

        if ($fanData !== null) {
            $telemetry_data->setFanData($fanData);
        }
        if ($heater_data !== null) {
            $telemetry_data->setHeaterData($heater_data);
        }
        if ($switch1_data !== null) {
            $telemetry_data->setSwitch1Data($switch1_data);
        }
        if ($switch2_data !== null) {
            $telemetry_data->setSwitch2Data($switch2_data);
        }
        if ($switch3_data !== null) {
            $telemetry_data->setSwitch3Data($switch3_data);
        }
        if ($switch4_data !== null) {
            $telemetry_data->setSwitch4Data($switch4_data);
        }
        if ($keypad_data !== null) {
            $telemetry_data->setKeypadData($keypad_data);
        }

        $this->entity_manager->persist($telemetry_data);
        $this->entity_manager->flush();
    }

    public function getLatestTelemetryData()
    {
        try {
            $query = $this->entity_manager->createQueryBuilder()
                ->select('data')
                ->from(TelemetryData::class, 'data')
                ->orderBy('data.created_at', 'DESC')
                ->setMaxResults(1)
                ->getQuery();

            return $query->getOneOrNullResult();

        } catch (\Exception $e) {
            $this->logger->error("Error fetching latest telemetry data: " . $e->getMessage());
            return null;
        }
    }

    public function isDataNew($received_time): bool {

        $latest_data = $this->getLatestTelemetryData();
        if (!$latest_data) {
            return true;
        }
        $latest_timestamp = $latest_data->getCreatedAt();
        return $received_time > $latest_timestamp;
    }

    public function processMessage($xml_string): array {
        $xml = new \SimpleXMLElement($xml_string);
        $message_content = (string)$xml->message;

        $processed_message = [
            'sourceMsisdn' => (string)$xml->sourcemsisdn,
            'destinationMsisdn' => (string)$xml->destinationmsisdn,
            'receivedTime' => (string)$xml->receivedtime,
            'bearer' => (string)$xml->bearer,
            'messageRef' => (string)$xml->messageref,
            'message' => $message_content,
            'messageType' => $this->findMessageType($message_content),
        ];

        $key_pairs = explode(';', $message_content);
        foreach ($key_pairs as $key_pair) {
            $message_parts = explode('=', $key_pair);
            if (count($message_parts) == 2) {
                $key_pair = strtolower(trim($message_parts[0]));
                $telemetry_data = trim($message_parts[1]);

                switch ($key_pair) {
                    case 'fan':
                        $processed_message['fanData'] = $telemetry_data;
                        break;
                    case 'heater':
                        $processed_message['heaterData'] = $telemetry_data;
                        break;
                    case 'keypad':
                        $processed_message['keypadData'] = $telemetry_data;
                        break;
                    case 'switch1':
                        $processed_message['switch1Data'] = $telemetry_data;
                        break;
                    case 'switch2':
                        $processed_message['switch2Data'] = $telemetry_data;
                        break;
                    case 'switch3':
                        $processed_message['switch3Data'] = $telemetry_data;
                        break;
                    case 'switch4':
                        $processed_message['switch4Data'] = $telemetry_data;
                        break;
                }
            }
        }
        return $processed_message;
    }

    private function findMessageType($message_content): string
    {
        return match ($message_content) {
            'fan' => 'fanData',
            'heater' => 'heaterData',
            'keypad' => 'keypadData',
            'switch1' => 'switch1Data',
            'switch2' => 'switch2Data',
            'switch3' => 'switch3Data',
            'switch4' => 'switch4Data',
            default => 'InvalidType'
        };
    }
}

