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

                    if ($this->telemetryModel->isDataNew($receivedTime)) {

                        $this->telemetryModel->storeTelemetryData(
                            $processedData['fanData'] ,
                            $processedData['heaterData'],
                            $processedData['switch1Data'],
                            $processedData['switch2Data'],
                            $processedData['switch3Data'],
                            $processedData['switch4Data'],
                            $processedData['keypadData']
                        );
                    }
                } catch (\Exception $innerException) {
                    $this->logger->error("Error processing individual message: " . $innerException->getMessage());
                }
            }
        } catch (\Exception $e) {
            $this->logger->error("Error in fetchAndStoreData: " . $e->getMessage());
        }
    }

    private function processMessage($xmlString): array
    {
        $xml = new \SimpleXMLElement($xmlString);

        $processedMessage = [
            'sourceMsisdn' => (string)$xml->sourcemsisdn,
            'destinationMsisdn' => (string)$xml->destinationmsisdn,
            'receivedTime' => (string)$xml->receivedtime,
            'bearer' => (string)$xml->bearer,
            'messageRef' => (string)$xml->messageref,
            'message' => (string)$xml->message,
            'messageType' => $this->determineMessageType((string)$xml->message),
        ];
        return $processedMessage;
    }

    private function determineMessageType($messageContent): string
    {
        return match ($messageContent) {
            'fan' => 'fanData',
            'heater' => 'heaterData',
            'keypad' => 'keypadData',
            'switch1' => 'switch1Data',
            default => 'unknownType'
        };


    }
}
