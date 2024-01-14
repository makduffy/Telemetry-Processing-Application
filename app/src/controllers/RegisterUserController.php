<?php

declare (strict_types=1);

namespace Telemetry\controllers;

/**
 *
 * Created by Rory Markham
 *
 * Class RegisterUserController
 *
 * Controller for handling requests related to user registration.
 */
class RegisterUserController
{
    public function showRegisterUserView(object $container, object $request, object $response): void
    {
        $register_user_view = $container->get('registerUserView');
        $view = $container->get('view');
        $settings = $container->get('settings');

        $register_user_view->createRegisterUserView($view, $settings, $response);
    }

    public function processRegistration(object $container, object $request, object $response): void
    {
        $register_user_view = $container->get('registerUserView');
        $user_model = $container->get('userModel');
        $view = $container->get('view');
        $settings = $container->get('settings');
        $register_user_view->createRegisterUserView($view, $settings, $response);
        $data = $request->getParsedBody();


        // Access username and password from $data array
        $username = $data['username'];
        $password = $data['password'];

        $password = $user_model->hashPassword($password);
        var_dump($password);
        $data = $user_model->storeUserData($username,$password);
        var_dump($data);


        // Now you have $username and $password variables to use as needed
        // Implement your user registration logic here...

        // Example: Print the values for demonstration
        echo "Username: $username, Password: $password";
    }
}
