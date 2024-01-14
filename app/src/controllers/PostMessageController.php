<?php

namespace Telemetry\Controllers;
class PostMessageController
{

    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $view = $container->get('view');
        $settings = $container->get('settings');
        $telemetry_view = $container->get('telemetryView');
        $logger = $container->get('logger');

        $logger->info("Creating HTML Output...");
        try {
            $telemetry_view->showPostMessagePage($view, $settings, $response);
            $logger->info("Successfully rendered the page.");

        } catch (\Exception $e) {
            $logger->error("Unsuccessfully created HTML Output");
        }
    }

}