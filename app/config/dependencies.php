<?php

declare (strict_types=1);

use DI\Container;
use Slim\App;
use Slim\Views\Twig;
use Telemetry\controllers\HomePageController;
use Telemetry\controllers\TelemetryController;
use Telemetry\models\TelemetryDetailModel;
use Telemetry\Support\DatabaseWrapper;
use Telemetry\Support\SoapWrapper;
use Telemetry\Views\TelemetryView;
use Telemetry\Views\HomePageView;

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

    $container->set('telemetryModel', function() {
        return new TelemetryDetailModel();
    });

    $container->set('soapWrapper', function () {
        return new SoapWrapper();
    });

    $container->set('databaseWrapper', function(){
        return new DatabaseWrapper();
    });

    $container->set('registerController', function(){
        return new \Telemetry\controllers\RegisterController();
    });

    $container->set('registerView', function(){
        return new \Telemetry\views\RegisterView();
    });
};
