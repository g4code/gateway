<?php

use G4\Gateway\HttpClient;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $optionsMock;

    protected function setUp()
    {
        $this->optionsMock = $this->getMockBuilder('\G4\Gateway\Options')
            ->disableOriginalConstructor()
            ->getMock();

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

        $this->client = new HttpClient($this->optionsMock);
    }

    protected function tearDown()
    {
        $this->optionsMock = null;
        $this->client = null;
    }

    public function testGetClient()
    {
        $this->assertInstanceOf('\Zend\Http\Client', $this->client->getClient());
    }

    public function testSend()
    {
        $paramsMock = $this->getMockBuilder('\G4\Gateway\Params')
            ->disableOriginalConstructor()
            ->getMock();

        $paramsMock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn(['id' => 123]);

        $urlMock = $this->getMockBuilder('\G4\Gateway\Url')
            ->disableOriginalConstructor()
            ->getMock();

        $urlMock
            ->expects($this->once())
            ->method('getParams')
            ->willReturn($paramsMock);

        $urlMock
            ->expects($this->once())
            ->method('getUri')
            ->willReturn('http://google.com');

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
            ->willReturn('GET');

        $this->assertInstanceOf('\G4\Gateway\Response', $this->client->send($urlMock, $methodMock));
    }
}