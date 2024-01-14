<?php
declare(strict_types=1);
namespace Telemetry\views;
use Psr\Log\LoggerInterface;

/**
 * Class TelemetryView
 *
 * View class for rendering the telemetry page.
*/

class TelemetryView
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function __destruct(){
    }
    public function showTelemetryPage($view, $settings, $response, $telemetry_data, $message_data): void
    {
        $landing_page = $settings['landing_page'];
        $css_path = $settings['css_path'];
        $application_name = $settings['application_name'];

        $fan_data = $telemetry_data->getFanData();
        $heater_data = $telemetry_data->getHeaterData();
        $switch1_data = $telemetry_data->getSwitch1Data();
        $switch2_data = $telemetry_data->getSwitch2Data();
        $switch3_data = $telemetry_data->getSwitch3Data();
        $switch4_data = $telemetry_data->getSwitch4Data();
        $keypad_data = $telemetry_data->getKeypadData();

        $createdAt = $message_data->getReceivedTime();
        $formattedDate = $createdAt->format('Y-m-d H:i:s');
        $msisdn = $message_data->getSourceMSISDN();
        $targetmsisdn = $message_data->getDestinationMSISDN();
        $message = $message_data->getMessage();

        $this->logger->info("Rendering Telemetry page");
        $view->render(
            $response,
            'displaytelemetry.html.twig',
            [
                'css_path' => $css_path,
                'landing_page' => $landing_page,
                'page_title' => $application_name,
                'page_heading_1' => $application_name,
                'initial_input_box_value' => null,
                'page_heading_2' => '',
                'legend' => 'S',
                'method' => 'get',
                'action' => '',
                'fandata' => $fan_data,
                'heaterdata' => $heater_data,
                'switch1data' => $switch1_data,
                'switch2data' => $switch2_data,
                'switch3data' => $switch3_data,
                'switch4data' => $switch4_data,
                'keypaddata' => $keypad_data,
                'createdat' => $formattedDate,
                'msisdn' => $msisdn,
                'targetmsisdn' => $targetmsisdn,
                'message' => $message
            ]
        );
        $this->logger->info("Telemetry page rendered successfully.");
    }

}