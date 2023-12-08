<?php

declare (strict_types=1);

use Telemetry\DatabaseWrapper;
use DI\Container;
use Slim\App;
use Slim\Views\Twig;
use Telemetry\controllers\HomePageController;
use Telemetry\views\HomePageView;

return function (Container $container, App $app)
{
    $settings = $app->getContainer()->get('settings');
    $template_path = $settings['view']['template_path'];
    $cache_path = $settings['view']['cache_path'];

    $container->set(
        'view',
        function () use ($template_path, $cache_path) {
            {
                return Twig::create($template_path, ['cache' => false]);
            }
        }
    );

    $container->set('homePageController', function () {
        return new HomePageController();
    });

    $container->set('databaseWrapper', function () {
        $database_wrapper_handle = new DatabaseWrapper();
        return $database_wrapper_handle;
    });

    $container->set('homePageView', function () {
        return new HomePageView();
    });
};
