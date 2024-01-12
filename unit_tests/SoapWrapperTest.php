<?php

namespace Telemetry;

use PHPUnit\Framework\TestCase;

class SoapWrapperTest extends TestCase
{

    private $logger;

    protected function setUp(): void
    {
        $this->logger = new Logger('test_logger');
        $this->logger->pushHandler(new StreamHandler('php://stdout', Logger::INFO));
    }
    public function testCreateSoapClientSuccess()
    {
        $settings = ['wsdl' => 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl'];
        $soapWrapper = new SoapWrapper($this->logger);

        $soapClient = $soapWrapper->createSoapClient($settings);

        $this->assertInstanceOf(\SoapClient::class, $soapClient);
    }

}