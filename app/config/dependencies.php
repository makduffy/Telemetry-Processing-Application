<?php

/***
 *  date 16/11/23
 *  Mak Duffy, Flavio Moreira and Rory Markham
 *  Sets up the dependencies
 * */

declare (strict_types=1);

use DI\Container;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Slim\App;
use Slim\Views\Twig;
use Telemetry\controllers\HomePageController;
use Telemetry\Controllers\postMessageController;
use Telemetry\controllers\RegisterUserController;
use Telemetry\controllers\TelemetryController;
use Telemetry\Models\PostMessageModel;
use Telemetry\models\TelemetryDetailModel;
use Telemetry\models\MessageDetailModel;
use Telemetry\models\UserDetailModel;
use Telemetry\Support\DatabaseWrapper;
use Telemetry\Support\SoapWrapper;
use Telemetry\Support\Validator;
use Telemetry\Views\HomePageView;
use Telemetry\Views\PostMessageView;
use Telemetry\views\RegisterUserView;
use Telemetry\views\SendMessageView;
use Telemetry\views\TelemetryView;



/**
 * date 16/11/23
 *
 * created by Mak Duffy, Flavio Moreira and Rory Markham
 *
 * Configures error middleware for the Slim application
 *
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

    $container->set('telemetryController', function($container) {
        return new TelemetryController();
    });

    $container->set('telemetryModel', function($container) {
        $logger = $container->get('logger');
        $entityManager = $container->get('entityManager');
        return new TelemetryDetailModel($logger, $entityManager);
    });


    $container->set('messageModel', function($container) {
        $logger = $container->get('logger');
        $entityManager = $container->get('entityManager');
        return new MessageDetailModel($logger, $entityManager);
    });


    $container->set('soapWrapper', function ($container) {
        $logger = $container->get('logger');
        return new SoapWrapper($logger);
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

    $container->set('registerUserView', function(){
        return new RegisterUserView();
    });

    $container->set('registerUserController', function(){
        return new RegisterUserController();
    });

    $container->set('sendMessageView', function(){
        return new SendMessageView();
    });

    $container->set('postMessageView', function(){
        return new PostMessageView();
    });

    $container->set('postMessageController', function(){
        return new PostMessageController();
    });

    $container->set('postMessageModel', function($container){
        $logger = $container->get('logger');
        $entityManager = $container->get('entityManager');
        return new PostMessageModel($logger, $entityManager);
    });

    $container->set('userModel', function($container) {
        $logger = $container->get('logger');
        $entityManager = $container->get('entityManager');
        return new UserDetailModel($logger, $entityManager);
    });


};
