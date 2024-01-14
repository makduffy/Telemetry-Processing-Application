<?php
global $app;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/post_message', function (Request $request, Response $response) use ($app) {

    $container = $app->getContainer();
    $logger = $container->get('logger');
    $post_message_view = $container->get('postMessageView');
    $post_message_model = $container->get('postMessageModel');
    $settings = $container->get('settings');

    $parsed_body = $request->getParsedBody();
    $message = $parsed_body('message');

    $post_message_model->sendMessage($container, $response, $message, $settings);
    $post_message_view->showPostMessagePage($container, $request, $response);
    $logger->info('Post message page created successfully');

    return $response;

});