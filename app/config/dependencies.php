<?php

declare (strict_types=1);

use DI\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Slim\App;
use Slim\Views\Twig;
use Telemetry\controllers\HomePageController;
use Telemetry\controllers\TelemetryController;
use Telemetry\models\TelemetryDetailModel;
use Telemetry\Support\DatabaseWrapper;
use Telemetry\Support\SoapWrapper;
use Telemetry\Support\Validator;
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

    $container->set('telemetryView', function ($container) {
        $logger = $container->get('logger');
        return new TelemetryView($logger);
    });

    $container->set('telemetryController', function($container)
    {
        $logger = $container->get('logger');
        return new TelemetryController($logger);
    });

    $container->set('telemetryModel', function($container) {
        $logger = $container->get('logger');
        return new TelemetryDetailModel($logger);
    });

    $container->set('soapWrapper', function ($container) {
        $logger = $container->get('logger');
        return new SoapWrapper($logger);
    });

    $container->set('databaseWrapper', function(){
        return new DatabaseWrapper();
    });

    $container->set('validator', function(){
        return new Validator();
    });

    $container->set('logger', function () {
        $logger = new Logger('monologger');
        $file_handler = new StreamHandler(__DIR__ . '/logs/app.log');
        $logger->pushHandler($file_handler);
        return $logger;
    });



    $container->set('registerView', function(){
        return new \Telemetry\views\RegisterView();
    });
};
