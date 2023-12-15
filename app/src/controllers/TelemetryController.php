<?php
declare (strict_types=1);
namespace Telemetry\controllers;

class TelemetryController {

    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $view =$container->get('view');
        $settings =$container->get('settings');
        $telemetry_view = $container->get('telemetryView');
        $telemetry_model = $container->get('telemetryModel');
        $soap_wrapper = $container->get('soapWrapper');
        $database_wrapper = $container->get('databaseWrapper');
        $validator = $container->get('validator');

        $telemetry_data = $telemetry_model->callTelemetryData($soap_wrapper, $settings);

        $fan_data = $validator->filterArray($telemetry_data, 'fan');
        $heater_data = $validator->filterArray($telemetry_data, 'heater');
        $keypad_data = $validator->filterArray($telemetry_data, 'keypad');
        $switch_data = $validator->filterArray($telemetry_data, 'switch');

        $fan_data_string = $validator->sanitizeData($fan_data);
        $heater_data_string = $validator->sanitizeData($heater_data);
        $switch_data_string = $validator->sanitizeData($switch_data);
        $keypad_data_string = $validator->sanitizeData($keypad_data);

        $telemetry_view->showTelemetryPage($view, $settings, $response, $fan_data_string, $heater_data_string, $switch_data_string, $keypad_data_string);
}

}
