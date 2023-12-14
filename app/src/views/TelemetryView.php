<?php
declare(strict_types=1);
namespace Telemetry\views;
class TelemetryView
{
    public function __construct(){
    }
    public function __destruct(){
    }

    public function showTelemetryPage($view, $settings, $response, $fan_data, $heater_data, $switch_data, $keypad_data): void
    {
        $landing_page = $settings['landing_page'];
        $css_path = $settings['css_path'];
        $application_name = $settings['application_name'];


        $view->render(
            $response,
            'displaytelemetry.html.twig',
            [
                'css_path' => $css_path,
                'landing_page' => $landing_page,
                'page_title' => $application_name,
                'page_heading_1' => $application_name,
                'initial_input_box_value' => null,
                'page_heading_2' => '',
                'legend' => 'S',
                'method' => 'get',
                'action' => '',
                'fandata' => $fan_data,
                'heaterdata' => $heater_data,
                'switchdata' => $switch_data,
                'keypaddata' => $keypad_data,
            ]
        );
    }

}