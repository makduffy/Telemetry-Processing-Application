<?php
declare (strict_types=1);
namespace Telemetry\controllers;

use Monolog\Logger;
use Telemetry\Models\TelemetryDetailModel;

class TelemetryController
{

    private Logger $logger;
    private TelemetryDetailModel $telemetryModel;

    public function __construct(Logger $logger, TelemetryDetailModel $telemetryModel)
    {
        $this->telemetryModel = $telemetryModel;
        $this->logger = $logger;
    }

    public function createHtmlOutput(object $container, object $request, object $response): void
    {

        $this->logger->info("Creating HTML Output...");

        try {

            $view = $container->get('view');
            $settings = $container->get('settings');
            $telemetry_view = $container->get('telemetryView');
            $telemetry_model = $container->get('telemetryModel');

            $telemetry_data = $telemetry_model->getLatestTelemetryData();

            $this->logger->info("Rendering the telemetry page.");
            $telemetry_view->showTelemetryPage($view, $settings, $response, $telemetry_data);
            $this->logger->info("Successfully rendered the telemetry page.");

        } catch (\Exception $e) {
            $this->logger->error("Unsuccessfully created HTML Output");
        }
    }

    public function fetchAndStoreData($container)
    {
        try {
            $soap_wrapper = $container->get('soapWrapper');
            $settings = $container->get('settings');
            $messages = $this->telemetryModel->callTelemetryData($soap_wrapper, $settings);

            foreach ($messages as $xmlString) {
                try {

                    $processedData = $this->processMessage($xmlString);
                    $receivedTime = $processedData['receivedTime'];
                    $receivedTime = \DateTime::createFromFormat('d/m/Y H:i:s', $receivedTime);
                    var_dump($processedData['forward']);
                    foreach ($processedData as $item) {
                        if (is_string($item) && str_contains('fanData',$item)) {
                            $filter = $item;
                            var_dump($filter);
                        }
                    } //
                    var_dump($processedData['fanData']['forward']);
                    var_dump($processedData['fanData']);
                    if ($this->telemetryModel->isDataNew($receivedTime)) {
                        $fanData = $filter['fanData'] ?? null;
                        //$heaterData = $processedData['heaterData'] ?? null;
                       // $keypadData = $processedData['keypadData'] ?? null;
                        //$switch1Data = $processedData['switch1Data'] ?? null;
                        //$switch2Data = $processedData['switch2Data'] ?? null;
                        //$switch3Data = $processedData['switch3Data'] ?? null;
                       // $switch4Data = $processedData['switch4Data'] ?? null;

                        $this->telemetryModel->storeTelemetryData(
                            $fanData );
                    }
                } catch (\Exception $innerException) {
                    $this->logger->error("Error processing individual message: " . $innerException->getMessage());
                }
            }
        } catch (\Exception $e) {
            $this->logger->error("Error in fetchAndStoreData: " . $e->getMessage());
        }
    }

    /**
     * Converts the XML object into a PHP string
     * Turns each child node of the XML object into an associative array
     */

    private function processMessage($xmlString): array {
        $xml = new \SimpleXMLElement($xmlString);
        $messageContent = (string)$xml->message;

        $processedMessage = [
            'sourceMsisdn' => (string)$xml->sourcemsisdn,
            'destinationMsisdn' => (string)$xml->destinationmsisdn,
            'receivedTime' => (string)$xml->receivedtime,
            'bearer' => (string)$xml->bearer,
            'messageRef' => (string)$xml->messageref,
            'message' => (string)$xml->message,
            'messageType' => $this->determineMessageType((string)$xml->message),
        ];

        $messageParts = explode('=', $messageContent);
        if (count($messageParts) == 2) {
            $key = trim($messageParts[0]);
            $value = trim($messageParts[1]);

            switch ($key) {
                case 'fan':
                    $processedMessage['fanData'] = $value;
                    break;
                case 'heater':
                    $processedMessage['heaterData'] = $value;
                    break;
                case 'switch1':
                    $processedMessage['switch1Data'] = $value;
                    break;
                case 'switch2':
                    $processedMessage['switch2Data'] = $value;
                    break;
                case 'switch3':
                    $processedMessage['switch3Data'] = $value;
                    break;
                case 'switch4':
                    $processedMessage['switch4Data'] = $value;
                    break;
                case 'keypad':
                    $processedMessage['keypadData'] = $value;
                    break;
            }
        }
        return $processedMessage;
    }
    private function determineMessageType($messageContent): string
    {
        return match ($messageContent) {
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
