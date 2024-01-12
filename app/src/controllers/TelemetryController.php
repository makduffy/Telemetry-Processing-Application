<?php
declare (strict_types=1);
namespace Telemetry\controllers;

use Monolog\Logger;

class TelemetryController {

    private Logger $logger;

    public function __construct(Logger $logger)
    {
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
            $soap_wrapper = $container->get('soapWrapper');
            $validator = $container->get('validator');

            $telemetry_data = $telemetry_model->callTelemetryData($soap_wrapper, $settings);

            $fan_data = $validator->filterArray($telemetry_data, 'fan');
            $heater_data = $validator->filterArray($telemetry_data, 'heater');
            $keypad_data = $validator->filterArray($telemetry_data, 'keypad');
            $switch1_data = $validator->filterArray($telemetry_data, 'switch1');
            $switch2_data = $validator->filterArray($telemetry_data, 'switch2');
            $switch3_data = $validator->filterArray($telemetry_data, 'switch3');
            $switch4_data = $validator->filterArray($telemetry_data, 'switch4');

            $fan_data_string = $validator->sanitizeData($fan_data);
            $heater_data_string = $validator->sanitizeData($heater_data);
            $switch1_data_string = $validator->sanitizeData($switch1_data);
            $switch2_data_string = $validator->sanitizeData($switch2_data);
            $switch3_data_string = $validator->sanitizeData($switch3_data);
            $switch4_data_string = $validator->sanitizeData($switch4_data);
            $keypad_data_string = $validator->sanitizeData($keypad_data);

            if ($fan_data_string !== null || $heater_data_string !== null || $switch1_data_string !== null || $switch2_data_string !== null || $switch3_data_string !== null || $switch4_data_string !== null) {
                $telemetry_model->storeTelemetryData($fan_data_string, $heater_data_string, $switch1_data_string, $switch2_data_string, $switch3_data_string, $switch4_data_string,$keypad_data_string);
            }
            $this->logger->info("Rendering the telemetry page.");
            $telemetry_view->showTelemetryPage($view, $settings, $response, $fan_data_string, $heater_data_string, $switch1_data_string, $switch2_data_string, $switch3_data_string, $switch4_data_string,$keypad_data_string);
            $this->logger->info("Successfully rendered the telemetry page.");
        } catch (\Exception $e) {
            $this->logger->error("Unsuccessfully created HTML Output");
        }
    }
}
