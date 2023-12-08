<?php

namespace Telemetry\views;

class RegisterView
{
    public function __construct() {}

    public function __destruct() {}

    public function createRegisterView($view, array $settings, $response): void
    {
        $landing_page = $settings['landing_page'];
        $application_name = $settings['application_name'];
        $css_path = $settings['css_path'];

        $view->render(
            $response,
            'register.html.twig',
            [
                'css_path' => $css_path,
                'application_name' => $application_name,
                'landing_page' => $landing_page,
                'initial_input_box_value' => null,

            ]);
    }
}