<?php
declare (strict_types=1);

use DI\Container;

/**
 * date 16/11/23
 * created by Mak Duffy and Flavio Moreira
 *
 *
 * Configures services and settings for the Slim application.
 *
 * @param Container $container The dependency injection container.
 * @param string $app_dir The base directory path of the application.
 *
 * @return array The configured settings array.
 */

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
                'deviceMSISDN' => '+447399474455',
                'countryCode' => '+44'
            ]

            /*'pdo_settings' => [
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
                    PDO::ATTR_EMULATE_PREPARES   => true
                ],
            ],
             */
        ];
    });
};
