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

    private $urlValue = 'http://google.com';

    private $methodValue = 'GET';

    private $paramsValue = ['id' => 123];

    protected function setUp()
    {
        $this->optionsMock = $this->getMockBuilder('\G4\Gateway\Options')
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new HttpClient($this->optionsMock);
    }

    protected function tearDown()
    {
        $this->optionsMock = null;
        $this->client = null;
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
        $paramsMock = $this->getMockBuilder('\G4\Gateway\Params')
            ->disableOriginalConstructor()
            ->getMock();

        $paramsMock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn($this->paramsValue);

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
            ->willReturn($this->urlValue);

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

        $httpClientMock = $this->getMockBuilder('\G4\Gateway\HttpClient')
            ->disableOriginalConstructor()
            ->setMethods(['getClient', 'getProfiler'])
            ->getMock();

        $httpClientMock
            ->expects($this->exactly(3))
            ->method('getClient')
            ->willReturn($this->clientMockFactory());

        $httpClientMock
            ->expects($this->exactly(2))
            ->method('getProfiler')
            ->willReturn($this->profilerMockFactory());

        $this->assertInstanceOf('\G4\Gateway\Response', $httpClientMock->send($urlMock, $methodMock));
    }

    private function clientMockFactory()
    {
        $responseMock = $this->getMockBuilder('\Zend\Http\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock = $this->getMockBuilder('\Zend\Http\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock
            ->expects($this->once())
            ->method('setUri')
            ->willReturnSelf();

        $clientMock
            ->expects($this->once())
            ->method('setMethod')
            ->willReturnSelf();

        $clientMock
            ->expects($this->once())
            ->method('send');

        $clientMock
            ->expects($this->once())
            ->method('getResponse')
            ->willReturn($responseMock);

        return $clientMock;
    }

    private function profilerMockFactory()
    {
        $uniqueId = md5(time());

        $profilerMock = $this->getMockBuilder('\G4\Gateway\Profiler\Ticker')
            ->disableOriginalConstructor()
            ->getMock();

        $profilerMock
            ->expects($this->once())
            ->method('start')
            ->willReturn($uniqueId);

        $profilerMock
            ->expects($this->once())
            ->method('setUrl')
            ->with($uniqueId, $this->urlValue)
            ->willReturnSelf();

        $profilerMock
            ->expects($this->once())
            ->method('setMethod')
            ->with($uniqueId, $this->methodValue)
            ->willReturnSelf();

        $profilerMock
            ->expects($this->once())
            ->method('setParams')
            ->with($uniqueId, $this->paramsValue)
            ->willReturnSelf();

        $profilerMock
            ->expects($this->once())
            ->method('end')
            ->with($uniqueId);

        return $profilerMock;
    }
}