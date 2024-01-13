<?php

declare (strict_types=1);

namespace Telemetry\controllers;

/**
 * Class RegisterUserController
 *
 * Controller for handling requests related to user registration.
 */
class RegisterUserController
{
    /**
     * Creates HTML output for the user registration page.
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
         * Retrieves the user registration view from the container.
         *
         * @var RegisterUserView $register_user_view
         */
        $register_user_view = $container->get('RegisterUserView');

        $view = $container->get('view');

        /**
         * Retrieves application settings from the container.
         *
         * @var array $settings
         */
        $settings = $container->get('settings');

        $register_user_view->createRegisterUserView($view, $settings, $response);
    }
}
