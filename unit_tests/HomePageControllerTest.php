<?php

namespace Telemetry;

use PHPUnit\Framework\TestCase;
use telemetry\controllers\HomePageController;

class HomePageControllerTest extends TestCase
{
    public function testCreateHtmlOutput(){
        $container = $this->createMock(\stdClass::class);
        $request = $this->createMock(\stdClass::class);
        $response = $this->createMock(\stdClass::class);
        $homePageView = $this->createMock(\stdClass::class);
        $view = $this->createMock(\stdClass::class);
        $settings = $this->createMock(\stdClass::class);

        $container->expects($this->exactly(3))
            ->method('get')
            ->withConsecutive(['homePageView'], ['view'], ['settings'])
            ->willReturnOnConsecutiveCalls($homePageView, $view, $settings);

        $controller = new HomePageController();

        $controller->createHtmlOutput($container, $request, $response);

        $homePageView->expects($this->once())
            ->method('createHomePageView')
            ->with($view, $settings, $response);

    }

}
