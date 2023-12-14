<?php
declare (strict_types=1);

use DI\Container;

return function (Container $container, string $app_dir){
    $app_url = dirname($_SERVER['SCRIPT_NAME']);

    $container->set('settings', function() use ($app_dir, $app_url)
    {
        return [
            'landing_page' => '/includes/telemetry',
            'application_name' => 'telemetry',
            'css_path' => $app_url . '/css/standard.css',

            'log_file_path' => '/p3t/phpappfolder/logs/',
            'displayErrorDetails' => true,
            'logErrorDetails' => true,
            'logErrors' => true,
            'addContentLengthHeader' => false,
            'mode' => 'development',
            'debug' => true,
            'wsdl' => 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl',
            'view' => [
                'template_path' => $app_dir . 'templates/',
                'cache_path' => $app_dir . 'cache/',
                'twig' => [
                    'cache' => false,
                    'auto_reload' => true
                ],
            ],

            'pdo_settings' => [
                'rdbms' => 'mysql',
                'host' => 'mariadb.dmu.ac.uk',
                'db_name' => 'p2599966db',
                'port' => '3306',
                'user_name' => 'p2599966_web',
                'user_password' => 'scuLk=70',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'options' => [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => true,
                ],

            ],

        ];
    });
};
