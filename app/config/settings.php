<?php
/**
 * Created by PhpStorm.
 * User: slim
 * Date: 13/10/17
 * Time: 12:33
 */

declare (strict_types=1);

use DI\Container;

// callback function to make settings available in an array

return function (Container $container, string $app_dir)
{
    $app_url = dirname($_SERVER['SCRIPT_NAME']);

    $container->set('settings', function() use ($app_dir, $app_url)
    {
        return [
            'landing_page' => '/includes/Telemetry',
            'application_name' => 'Telemetry',
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
            'options' => [
            ]
        ];
        }
    );
};

