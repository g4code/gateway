<?php

use G4\Gateway\Http;
use G4\Gateway\Params;
use G4\Gateway\HttpMethod;
use G4\Gateway\FullRequestInfo;
use G4\Gateway\Response as HttpResponse;

class FullRequestInfoTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Http
     */
    private $http;

    private $optionsMock;

    protected function setUp(): void
    {
        $this->optionsMock = $this->getMockBuilder('\G4\Gateway\Options')
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        $this->optionsMock = null;
        $this->http        = null;
    }

    public function testGetResponseBody()
    {
        $this->assertEquals(
            'http://google.com',
            $this->responseFactory()->getResponseBody()
        );
    }

    public function testGetStatusCode()
    {
        $this->assertEquals(
            200,
            $this->responseFactory()->getStatusCode()
        );
    }

    public function testGetParams()
    {
        $this->assertEquals(
            [
                'id'    => '43069085',
                'email' => 'test@example.com',
            ],
            $this->responseFactory()->getParams()->toArray()
        );
    }

    public function testGetRequestHeaders()
    {
        $this->assertEquals(
            [
                'Server'       => 'Apache',
                'Content-Type' => 'application/json',
            ],
            $this->responseFactory()->getRequestHeaders()
        );
    }

    public function testGetResponseHeaders()
    {
        $this->assertEquals(
            [
                'Content-Type' => 'application/json'
            ],
            $this->responseFactory()->getResponseHeaders()
        );
    }

    public function testGetUrl()
    {
        $this->assertEquals('http://google.com', $this->responseFactory()->getUrl());
    }

    public function testGetMethodName()
    {
        $this->setHttpMock();
        $this->http->post([]);
        $this->assertEquals(HttpMethod::POST, $this->http->getMethodName());
    }

    private function responseFactory()
    {
        return (new FullRequestInfo($this->httpMockFactory(), $this->httpResponseMockSuccessFactory()));
    }

    private function httpResponseMockSuccessFactory()
    {
        $httpGatewayResponseMock = $this->getMockBuilder(HttpResponse::class)
            ->disableOriginalConstructor()
            ->getMock();

        $httpGatewayResponseMock
            ->expects($this->any())
            ->method('getCode')
            ->willReturn(200);

        $httpGatewayResponseMock
            ->expects($this->any())
            ->method('getParams')
            ->willReturn($this->paramsMockFactory());

        $httpGatewayResponseMock
            ->expects($this->any())
            ->method('getHeaders')
            ->willReturn(
                [
                    'Content-Type' => 'application/json'
                ]
            );

        $httpGatewayResponseMock
            ->expects($this->any())
            ->method('getBody')
            ->willReturn(
                'http://google.com'
            );

        return $httpGatewayResponseMock;
    }

    private function httpMockFactory()
    {
        $httpGatewayMock = $this->getMockBuilder(Http::class)
            ->disableOriginalConstructor()
            ->getMock();

        $httpGatewayMock
            ->expects($this->any())
            ->method('getHeaders')
            ->willReturn(
                [
                    'Server'       => 'Apache',
                    'Content-Type' => 'application/json',
                ]
            );

        $httpGatewayMock
            ->expects($this->any())
            ->method('getUri')
            ->willReturn('http://google.com');

        return $httpGatewayMock;
    }

    private function paramsMockFactory()
    {
        $paramsMock = $this->getMockBuilder(Params::class)
            ->disableOriginalConstructor()
            ->getMock();

        $paramsMock
            ->expects($this->any())
            ->method('toArray')
            ->willReturn(
                [
                    'id'    => '43069085',
                    'email' => 'test@example.com',
                ]
            );

        return $paramsMock;
    }

    private function setHttpMock()
    {
        $responseMock = $this->getMockBuilder('\G4\Gateway\Client\ComplexResponse')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock = $this->getMockBuilder('\G4\Gateway\Client\ComplexHttpClient')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock
            ->expects($this->once())
            ->method('send')
            ->willReturn($responseMock);

        $this->http = $this->getMockBuilder('\G4\Gateway\Http')
            ->setConstructorArgs(['http://google.com', $this->optionsMock])
            ->setMethods(['makeClient'])
            ->getMock();

        $this->http
            ->expects($this->once())
            ->method('makeClient')
            ->willReturn($clientMock);
    }
}