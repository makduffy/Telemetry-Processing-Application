<?php
declare (strict_types=1);
namespace Telemetry;
class HomePageView
{
    public function __construct() {}

    public function __destruct() {}

    public function createHomePageView($view, array $settings, $response): void
    {
        $landing_page = $settings['landing_page'];
        $application_name = $settings['application_name'];
        $css_path = $settings['css_path'];

        $view->render(
            $response,
            'homepageform.html.twig',
            [
                'css_path' => $css_path,
                'application_name' => $application_name,
                'landing_page' => $landing_page,
                'initial_input_box_value' => null,
                'action' => 'telemetrymain'
            ]);
    }

}