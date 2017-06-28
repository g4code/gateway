<?php

use G4\Gateway\Client\ComplexHttpClient;

class ComplexHttpClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ComplexHttpClient
     */
    private $client;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $optionsMock;
    private $urlValue       = 'http://google.com';
    private $methodValue    = 'GET';
    private $paramsValue    = ['id' => 123];

    protected function setUp()
    {
        $this->optionsMock = $this->getMockBuilder('\G4\Gateway\Options')
            ->disableOriginalConstructor()
            ->getMock();

        $this->optionsMock
            ->expects($this->any())
            ->method('getHeaders')
            ->willReturn([
                'Server'        => 'Apache',
                'Cache-Control' => 'no-cache',
                'Content-Type'  => 'application/pdf',
            ]);

        $this->client = new ComplexHttpClient($this->optionsMock);
    }

    protected function tearDown()
    {
        $this->optionsMock = null;
        $this->client      = null;
    }

    public function testGetClient()
    {
        $this->optionsMock
            ->expects($this->once())
            ->method('getTimeout')
            ->willReturn(10);

        $this->optionsMock
            ->expects($this->once())
            ->method('getSslVerifyPeer')
            ->willReturn(true);

            $this->optionsMock
                ->expects($this->once())
                ->method('getHeaders')
                ->willReturn([]);

        $this->assertInstanceOf('\Zend\Http\Client', $this->client->getClient());
    }

    public function testGetProfiler()
    {
        $this->assertInstanceOf('\G4\Gateway\Profiler\Ticker', $this->client->getProfiler());
    }

    public function testSend()
    {
        $this->assertInstanceOf('\G4\Gateway\Client\ComplexResponse', $this->client->send($this->urlMock(), $this->methodMock()));
    }

    private function urlMock()
    {
        $urlMock = $this->getMockBuilder('\G4\Gateway\Url')
            ->disableOriginalConstructor()
            ->getMock();

        $urlMock
            ->expects($this->once())
            ->method('getParams')
            ->willReturn($this->paramsMock());

        $urlMock
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($this->urlValue);

        return $urlMock;
    }

    private function methodMock()
    {
        $methodMock = $this->getMockBuilder('\G4\Gateway\HttpMethod')
            ->disableOriginalConstructor()
            ->getMock();

        $methodMock
            ->expects($this->once())
            ->method('isPost')
            ->willReturn(false);

        $methodMock
            ->expects($this->once())
            ->method('__toString')
            ->willReturn($this->methodValue);

        return $methodMock;
    }

    private function paramsMock()
    {
        $paramsMock = $this->getMockBuilder('\G4\Gateway\Params')
            ->disableOriginalConstructor()
            ->getMock();

        $paramsMock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn($this->paramsValue);

        return $paramsMock;
    }
}