<?php
declare (strict_types=1);

use DI\Container;

return function (Container $container, string $app_dir)
{
    $app_url = dirname($_SERVER['SCRIPT_NAME']);

    $container->set(
        'settings',
        function()
        use ($app_dir, $app_url)
    {
        return [
            'landing_page' => '/includes/telemetry',
            'application_name' => 'telemetry',
            'css_path' => $app_url . '/css/standard.css',

            'log_file_path' => '/p3t/phpappfolder/telemetry',
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

            'doctrine' => [
                'meta' => [
                    'entity_path' => [$app_dir . 'src/Entities'],
                    'auto_generate_proxies' => true,
                    'proxy_dir' => $app_dir . 'cache/proxies',
                    'cache' => null,
                ],
                'doctrine_connection' => [
                    'driver' => 'pdo_mysql',
                    'host' => 'localhost',
                    'port' => '3306',
                    'charset' => 'utf8mb4',
                    'user'     => 'telemetry_user',
                    'dbname'   => 'telemetry',
                    'password' => 'telemetry12',
                ],
            ],

            'M2M_Details' => [
                'username' => '23_2635754',
                'password' => 'DoorDash!!12',
                'count' => '25',
                'deviceMSISDN' => '+447452835992',
                'countryCode' => '+44',
                'M2MNumber' => '+447817814149'
            ]
        ];
    });
};
