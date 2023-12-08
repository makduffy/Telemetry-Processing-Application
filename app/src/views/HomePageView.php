<?php
declare (strict_types=1);
namespace Telemetry\views;
class HomePageView
{
    public function __construct() {}

    public function __destruct() {}

    public function createHomePageView($view, array $settings, $response): void
    {
        $landing_page = $settings['landing_page'];
        $application_name = $settings['application_name'];
        $css_path = $settings['css_path'];


    }

}