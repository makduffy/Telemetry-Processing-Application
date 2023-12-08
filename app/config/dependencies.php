<?php

declare (strict_types=1);

use Telemetry\HomePageController;
use Telemetry\HomePageView;
use DI\Container;
use Slim\Views\Twig;
use Slim\App;
use Telemetry\TelemetryController;
use Telemetry\TelemetryView;

return function (Container $container, App $app) {
    $settings = $app->getContainer()->get('settings');
    $template_path = $settings['view']['template_path'];
    $cache_path = $settings['view']['cache_path'];

    $container->set('view', function () use ($template_path, $cache_path) {
        {
            return Twig::create($template_path, ['cache' => false]);
        }
    }
    );

    $container->set('homePageController', function () {
        return new HomePageController();
    });

    $container->set('homePageView', function () {
        return new HomePageView();
    });

    $container->set('telemetryView', function () {
        return new TelemetryView();
    });

    $container->set('telemetryController', function()
    {
        return new TelemetryController();
    });


};
