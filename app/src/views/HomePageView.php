<?php
declare (strict_types=1);
namespace Telemetry\views;
/**
 * Class HomePageView
 *
 * View class for rendering the homepage
 *
 */

class HomePageView
{
    public function __construct() {}

    public function __destruct() {}

    /**
     * Creates the HTML view for the homepage
     *
     * @param $view
     * @param array $settings
     * @param $response
     *
     * @return void
     */

    public function createHomePageView($view, array $settings, $response): void
    {
        // Retrieve settings for rendering
        $landing_page = $settings['landing_page'];
        $application_name = $settings['application_name'];
        $css_path = $settings['css_path'];

        //Render the homepage using the specified template
        $view->render(
            $response,
            'homepageform.html.twig',
            [
                'css_path' => $css_path,
                'application_name' => $application_name,
                'landing_page' => $landing_page,
                'initial_input_box_value' => null,
                'action' => 'telemetrymain'
            ]);
    }

}