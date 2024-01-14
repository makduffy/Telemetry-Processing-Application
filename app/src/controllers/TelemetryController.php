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

        $logger->info("Creating HTML Output...");

        try {

            $telemetry_data = $telemetry_model->getLatestTelemetryData();

            $logger->info("Rendering the telemetry page.");
            $telemetry_view->showTelemetryPage($view, $settings, $response, $telemetry_data);
            $logger->info("Successfully rendered the telemetry page.");

        } catch (\Exception $e) {
            $logger->error("Unsuccessfully created HTML Output");
        }
    }


    public function fetchAndStoreData(object $container)

    /** Creates HTML output for telemetry page
     *
     * @param object $container
     * @param object $request
     * @param object $response
     *
     * @return void
     */

    {

        $soap_wrapper = $container->get('soapWrapper');
        $settings = $container->get('settings');
        $telemetry_model = $container->get('telemetryModel');
        $messages_model = $container->get('messageModel');
        $logger = $container->get('logger');

        try {


            $messages = $telemetry_model->callTelemetryData($soap_wrapper, $settings);

            foreach ($messages as $xmlString) {
                try {

                    $processedData = $telemetry_model->processMessage($xmlString);
                    $processedMetaData = $messages_model->processMessageData($xmlString);
                    $receivedTime = $processedData['receivedTime'];
                    $receivedTime = \DateTime::createFromFormat('d/m/Y H:i:s', $receivedTime);

                    if ($telemetry_model->isDataNew($receivedTime)) {
                        $fanData = $processedData['fanData'] ?? null;
                        $heaterData = $processedData['heaterData'] ?? null;
                        $keypadData = $processedData['keypadData'] ?? null;
                        $switch1Data = $processedData['switch1Data'] ?? null;
                        $switch2Data = $processedData['switch2Data'] ?? null;
                        $switch3Data = $processedData['switch3Data'] ?? null;
                        $switch4Data = $processedData['switch4Data'] ?? null;


                        $sourceMSISDN = $processedData['sourceMsisdn'] ?? null;
                        $destinationMsisdn = $processedData['destinationMsisdn'] ?? null;
                        $bearer = $processedData['bearer'] ?? null;
                        $messageRef = $processedData['messageRef'] ?? null;
                        $message = $processedData['message'] ?? null;


                        /**
                        $sourceMSISDN = $processedMetaData['sourcemsisdn'] ?? null;
                        $destinationMsisdn = $processedMetaData['destinationmsisdn'] ?? null;
                        $bearer = $processedMetaData['bearer'] ?? null;
                        $messageRef = $processedMetaData['messageref'] ?? null;
                        $message = $processedMetaData['message'] ?? null;
                        var_dump($processedData);
                        var_dump($processedMetaData);
                         */
                        $messages_model->storeMessageData($sourceMSISDN, $destinationMsisdn, $bearer, $messageRef, $message);
                        $telemetry_model->storeTelemetryData($fanData, $heaterData, $switch1Data, $switch2Data, $switch3Data, $switch4Data, $keypadData);

                    }


                } catch (\Exception $innerException) {
                    $logger->error("Error processing individual message: " . $innerException->getMessage());
                }
            }

        } catch (\Exception $e) {
            $logger->error("Error in fetchAndStoreData: " . $e->getMessage());
        }
    }
}
