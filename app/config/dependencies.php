<?php


declare (strict_types=1);

use Telemetry\HomePageController;
use Telemetry\HomePageView;

use DI\Container;
use Slim\Views\Twig;
use Slim\App;

// Register components in a container

return function (Container $container, App $app) {
    $settings = $container->get('settings');
    $template_path = $settings['view']['template_path'];
    $cache_path = $settings['view']['cache_path'];

    $container->set(
        'view',
        function ()
        use ($template_path, $cache_path) {
            {
                return Twig::create($template_path, ['cache' => false]);
            }
        }
    );

    /**
     * Using Doctrine
     * @param $c
     * @return \Doctrine\ORM\EntityManager
     * @throws \Doctrine\ORM\Exception\ORMException
     */

    $container->set('em', function ($c) {
        $settings = $c->get('settings');
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            $settings['doctrine']['meta']['entity_path'],
            $settings['doctrine']['meta']['auto_generate_proxies'],
            $settings['doctrine']['meta']['proxy_dir'],
            $settings['doctrine']['meta']['cache'],
            false
        );
        return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
    });

    $container->set('homePageController', function () {
        $controller = new HomePageController();
        return $controller;
    });

    $container->set('homePageView', function () {
        $view = new HomePageView();
        return $view;
    });







};