<?php
namespace Telemetry\views;
class SendMessageView
{
    public function showSendMessagePage($view, $settings, $response): void
    {
        $landing_page = $settings['landing_page'];
        $css_path = $settings['css_path'];
        $application_name = $settings['application_name'];

        $view->render(
            $response,
            'sendmessage.html.twig',
            [
                'css_path' => $css_path,
                'landing_page' => $landing_page,
                'page_title' => $application_name,
                'page_heading_1' => $application_name,
                'initial_input_box_value' => null,
                'method' => 'post',
                'action' => 'postMessage',

            ]
        );
    }
}