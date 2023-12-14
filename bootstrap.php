<?php

declare (strict_types=1);

use DI\Container;
use Slim\Factory\AppFactory;


if (session_start()) {

    require 'vendor/autoload.php';

    $base_dir = dirname(__DIR__);
    $app_dir = $base_dir .'/telemetry/app/';
    $config_dir = $app_dir . 'config/';
    $routes_dir =  $app_dir . 'routes/';

    $container = new Container();

    AppFactory::setContainer($container);

    $app = AppFactory::create();

    $app->setBasePath('/telemetry');

    $settings = require $config_dir . 'settings.php';
    $settings($container, $app_dir);

    $middleware = require $config_dir . 'middleware.php';
    $middleware($app);

    $dependencies = require $config_dir . 'dependencies.php';
    $dependencies($container, $app);

    require $routes_dir . 'routes.php';

    $app->run();
}