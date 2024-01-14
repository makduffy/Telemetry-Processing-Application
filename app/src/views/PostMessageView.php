<?php

namespace Telemetry\Views;

/**
 * Class PostMessageView
 *
 * Represents the view for displaying the post message page.
 *
 */

class PostMessageView
{
    public function showPostMessagePage($view, $settings, $response): void
    {
        $landing_page = $settings['landing_page'];
        $css_path = $settings['css_path'];
        $application_name = $settings['application_name'];

        $view->render(
            $response,
            'postmessage.html.twig',
            [
                'css_path' => $css_path,
                'landing_page' => $landing_page,
                'page_title' => $application_name,
                'page_heading_1' => $application_name,
                'initial_input_box_value' => null,
            ]
        );
    }

}