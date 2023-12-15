<?php

declare (strict_types=1);

namespace Telemetry\controllers;

class RegisterController
{
    public function createHtmlOutput(object $container, object $request, object $response): void
    {
        $register_view = $container->get('registerView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        $register_view->createRegisterView($view, $settings, $response);
    }

}