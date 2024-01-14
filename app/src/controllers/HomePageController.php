<?php

declare (strict_types=1);

namespace Telemetry\controllers;
/**
 * Class HomePageController
 *
 * Controller for handling requests related to the home page.
 */

class HomePageController
{
    /**
     * Creates HTML output for the home page.
     *
     * @param object $container The dependency injection container.
     * @param object $request The HTTP request object.
     * @param object $response The HTTP response object.
     *
     * @return void
     */
    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        /**
         * Retrieves the home page view from the container.
         *
         * @var HomePageView $homepage_view
         */
        $homepage_view = $container->get('homePageView');
        /**
         * Retrieves the main view renderer from the container.
         *
         * @var Twig $view
         */
        $view = $container->get('view');
        /**
         * Retrieves application settings from the container.
         *
         * @var array $settings
         */
        $settings = $container->get('settings');
        /** Invokes the method to create the home page view. */
        $homepage_view->createHomePageView($view, $settings, $response);
    }
}