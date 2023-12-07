<?php

/**
 * LandingPageController.php
 *
 *
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 * @package dates services
 */

namespace Telemetry;

class HomePageController
{

    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $homepage_view = $container->get('homePageView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        $homepage_view->createHomePageView($view, $settings, $response);
    }
}