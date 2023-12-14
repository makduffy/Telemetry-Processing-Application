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

        $telemetry_data = $telemetry_model->callTelemetryData($soap_wrapper, $settings);

        $fan_data = $telemetry_model->filterArray($telemetry_data, 'fan');
        $heater_data = $telemetry_model->filterArray($telemetry_data, 'heater');
        $keypad_data = $telemetry_model->filterArray($telemetry_data, 'keypad');
        $switch_data = $telemetry_model->filterArray($telemetry_data, 'switch');

        $fan_data = $telemetry_model->sanitizeData($fan_data);
        $heater_data = $telemetry_model->sanitizeData($heater_data);
        $keypad_data = $telemetry_model->sanitizeData($keypad_data);
        $switch_data = $telemetry_model->sanitizeData($switch_data);

        $telemetry_view->showTelemetryPage($view, $settings, $response, $fan_data, $heater_data, $switch_data, $keypad_data);
}

}
