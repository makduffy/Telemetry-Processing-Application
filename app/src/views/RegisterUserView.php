<?php
declare (strict_types=1);
namespace Telemetry\views;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class RegisterUserView
 *
 * View class for rendering the register user page
 *
 */
class RegisterUserView
{
    public function __construct() {}

    public function __destruct() {}



    public function createRegisterUserView($view, array $settings, Response $response): void
    {

        // Retrieve settings for rendering

        $css_path = $settings['css_path'];
        $application_name = $settings['application_name'];

        // Render the register user page using the specified template
        $view->render(
            $response,
            'registeruser.html.twig',
            [
                'css_path' => $css_path,
                'application_name' => $application_name,
                'initial_input_box_value' => null,
                'action' => '/registeruser', // Adjust the URL based on your route setup
            ]
        );
    }
}

