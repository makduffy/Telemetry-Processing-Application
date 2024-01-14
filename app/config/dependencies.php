<?php

/***
 *  date 16/11/23
 *  Mak Duffy, Flavio Moreira and Rory Markham
 *  Sets up the dependencies
 * */

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
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Setup;
use DoctrineSessions\Support\DoctrineSqlQueries;



/**
 * Configures services and settings for the Slim application
 *
 * @param Container $container The dependency injection container
 * @param App $app The slim application instance
 *
 */

return function (Container $container, App $app) {
    $settings = $app->getContainer()->get('settings');
    $template_path = $settings['view']['template_path'];
    $cache_path = $settings['view']['cache_path'];

    /**
     * Sets up the Twig template engine for rendering views
     *
     * @return Twig
     */

    $container->set('view', function () use ($template_path, $cache_path) {
        {
            return Twig::create($template_path, ['cache' => false]);
        }
    }
    );

    /**
     * Creates an instance of HomePageController
     *
     * @return HomePageController
     *
     */

    $container->set('homePageController', function () {
        return new HomePageController();
    });

    /**
     * Creates an instance of HomePageView
     *
     * @return HomePageView
     *
     */

    $container->set('homePageView', function () {
        return new HomePageView();
    });

    /**
     * Creates an instance of TelemetryView
     *
     * @return TelemetryView
     *
     */

    $container->set('telemetryView', function ($container) {
        $logger = $container->get('logger');
        return new TelemetryView($logger);
    });



    /**
     * Creates an instance of TelemetryController
     *
     * @return TelemetryController
     *
     */

    $container->set('telemetryController', function($container)
    {
        $logger = $container->get('logger');
        return new TelemetryController($logger);

    });

    /**
     * Creates an instance of TelemetryDetailModel
     *
     * @return TelemetryDetailModel
     *
     */

    $container->set('telemetryModel', function($container) {
        $logger = $container->get('logger');
        $entityManager = $container->get('entityManager');
        return new TelemetryDetailModel($logger, $entityManager);
    });

    /**
     * Creates an instance of SoapWrapper
     *
     * @return SoapWrapper
     *
     */

    $container->set('soapWrapper', function ($container) {
        $logger = $container->get('logger');
        return new SoapWrapper($logger);
    });

    /**
     * Creates an instance of DatabaseWrapper
     *
     * @return DatabaseWrapper
     *
     */

    $container->set('databaseWrapper', function(){
        return new DatabaseWrapper();
    });

    /**
     * Creates an instance of Validator
     *
     * @return Validator
     */

    $container->set('validator', function(){
        return new Validator();
    });

    /**
     * Creates a Monolog logger instance
     *
     * @return $logger
     */

    $container->set('logger', function () {
        $logger = new Logger('monologger');
        $file_handler = new StreamHandler(__DIR__ . '/logs/app.log');
        $logger->pushHandler($file_handler);
        return $logger;
    });

    $container->set('entityManager', function ($c) {
        $settings = $c->get('settings')['doctrine'];

        $dbConnection = DriverManager::getConnection($settings['doctrine_connection']);
        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['meta']['entity_path'],
            $settings['meta']['auto_generate_proxies'],
            $settings['meta']['proxy_dir'],
            $settings['meta']['cache'],
            false
        );

        return new EntityManager($dbConnection, $config);
    });

    /**
     * Creates an instance of RegisterView.
     *
     * @return RegisterView
     */

    $container->set('RegisterUserView', function(){
        return new Telemetry\Views\RegisterUserView();
    });

    $container->set('RegisterUserController', function(){
        return new Telemetry\controllers\RegisterUserController();
    });

};
