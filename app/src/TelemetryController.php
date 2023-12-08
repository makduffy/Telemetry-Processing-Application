<?php
declare (strict_types=1);
namespace Telemetry;

class TelemetryController {

    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $view =$container->get('view');
        $settings =$container->get('settings');

        $telemetry_view = $container->get('telemetryView');

        $telemetry_view->showTelemetryData($view, $settings, $response);

}


}
