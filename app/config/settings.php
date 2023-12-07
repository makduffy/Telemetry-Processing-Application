<?php
declare (strict_types=1);

return function (Container $container, string $app_dir){
    $app_url = dirname($_SERVER['SCRIPT_NAME']);

    $container->set('settings', function() use ($app_dir, $app_url)
    {
        return [
            'landing_page' => 'telemetry_project/telemetry/',
            'application_name' => 'Telemetry App',
            'css_path' => $app_url . 'css/standard.css',
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
            'm2m credentials' => [
                'username' => '',
                'password' => '',
                'count' => "100",
                'deviceMSISDN' => "+447817814149",
                'countryCode' => "44"
            ]

        ];
    });
};
