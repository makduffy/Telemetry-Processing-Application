<?php
declare (strict_types=1);
namespace Telemetry\controllers;

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
    {

        $soap_wrapper = $container->get('soapWrapper');
        $settings = $container->get('settings');
        $telemetry_model = $container->get('telemetryModel');
        $logger = $container->get('logger');

        try {

            $messages = $telemetry_model->callTelemetryData($soap_wrapper, $settings);

            foreach ($messages as $xmlString) {
                try {

                    $processedData = $telemetry_model->processMessage($xmlString);
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