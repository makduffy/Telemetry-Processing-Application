<?php
declare (strict_types=1);
namespace Telemetry\controllers;

use Telemetry\Models\MessageDetailModel;

class TelemetryController
{

    public function createHtmlOutput(object $container, object $request, object $response): void

    {
        $view = $container->get('view');
        $settings = $container->get('settings');
        $telemetry_view = $container->get('telemetryView');
        $telemetry_model = $container->get('telemetryModel');
        $logger = $container->get('logger');
        $messages_model = $container->get('messageModel');

        $logger->info("Creating HTML Output...");

        try {

            $telemetry_data = $telemetry_model->getLatestTelemetryData();
            $message_data = $messages_model->getLatestMessageData();
            $logger->info("Rendering the telemetry page.");
            $telemetry_view->showTelemetryPage($view, $settings, $response, $telemetry_data, $message_data);
            $logger->info("Successfully rendered the telemetry page.");

        } catch (\Exception $e) {
            $logger->error("Unsuccessfully created HTML Output");
        }
    }

    public function fetchAndStoreData(object $container): void
    {
        $soap_wrapper = $container->get('soapWrapper');
        $settings = $container->get('settings');
        $telemetry_model = $container->get('telemetryModel');
        $messages_model = $container->get('messageModel');
        $logger = $container->get('logger');

        $logger->info("Retrieving the message");
        try {

            $messages = $telemetry_model->callTelemetryData($soap_wrapper, $settings);

            foreach ($messages as $xmlString) {
                $logger->info("Storing the data");
                try {

                    $processedData = $telemetry_model->processMessage($xmlString);
                    $processedMetaData = $messages_model->processMessageData($xmlString);
                    $receivedTimeTelemetry = $processedData['receivedTime'];
                    $receivedTimeMetaData = $processedMetaData['receivedTime'];
                    $receivedTimeTelemetry = \DateTime::createFromFormat('d/m/Y H:i:s', $receivedTimeTelemetry);

                    if ($telemetry_model->isTelemetryDataNew($receivedTimeTelemetry)) {
                        $fanData = $processedData['fanData'] ?? null;
                        $heaterData = $processedData['heaterData'] ?? null;
                        $keypadData = $processedData['keypadData'] ?? null;
                        $switch1Data = $processedData['switch1Data'] ?? null;
                        $switch2Data = $processedData['switch2Data'] ?? null;
                        $switch3Data = $processedData['switch3Data'] ?? null;
                        $switch4Data = $processedData['switch4Data'] ?? null;

                        $telemetry_model->storeTelemetryData($fanData, $heaterData, $switch1Data, $switch2Data, $switch3Data, $switch4Data, $keypadData);

                    }

                    $receivedTimeMetaData = \DateTime::createFromFormat('d/m/Y H:i:s', $receivedTimeMetaData);

                    if ($messages_model->isMessageDataNew($receivedTimeMetaData)){
                        $sourceMSISDN = $processedMetaData['sourceMsisdn'] ?? null;
                        $destinationMsisdn = $processedMetaData['destinationMsisdn'] ?? null;
                        $bearer = $processedMetaData['bearer'] ?? null;
                        $messageRef = $processedMetaData['messageRef'] ?? null;
                        $message = $processedMetaData['message'] ?? null;

                        $messages_model->storeMessageData($sourceMSISDN, $destinationMsisdn, $bearer, $messageRef, $message);
                    }


                } catch (\Exception $innerException) {
                    $logger->error("Could not store the data " . $innerException->getMessage());
                }
            }
        } catch (\Exception $e) {
            $logger->error("Could not retrieve the data " . $e->getMessage());
        }
    }
}
