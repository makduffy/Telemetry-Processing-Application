<?php

declare (strict_types=1);

namespace Telemetry\controllers;
/**
 * Created by Mak Duffy
 *
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
        $homepage_view = $container->get('homePageView');

        $view = $container->get('view');

        $settings = $container->get('settings');
        $homepage_view->createHomePageView($view, $settings, $response);
    }

    public function validateUser(object $container, object $request, object $response)
    {
        $user_model = $container->get('userModel');
        $data = $request->getParsedBody();

        $username = $data['username'];
        $password = $data['password'];
        $password = $user_model->hashPassword($password);
        if ($this->userService->authenticate($username, $password)) {
            return new Response('Authentication successful');
        }

        return new Response('Authentication failed');
    }
}