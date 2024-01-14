<?php

declare (strict_types=1);

namespace Telemetry\controllers;

/**
 *
 * Created by Rory Markham
 *
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

        $register_user_view = $container->get('registerUserView');

        $view = $container->get('view');


        $settings = $container->get('settings');

        $register_user_view->createRegisterUserView($view, $settings, $response);
    }
}
