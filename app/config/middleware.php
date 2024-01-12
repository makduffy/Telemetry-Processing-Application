<?php

declare(strict_types=1);

use Slim\App;

/**
 * Configures error middleware for the Slim application
 *
 * @param App $app - An instance of App
 */

return function (App $app)
{
    $settings = $app->getContainer()->get('settings');

    /**
     * Adds error middleware to the application
     */

    $app->addErrorMiddleware(
        $settings['displayErrorDetails'],
        $settings['logErrorDetails'],
        $settings['logErrors']
    );
};