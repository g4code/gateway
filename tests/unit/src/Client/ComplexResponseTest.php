<?php

use G4\Gateway\Url;
use Laminas\Http\Headers;
use Laminas\Http\AbstractMessage;
use G4\Gateway\Client\ComplexResponse;
use Laminas\Http\Response as ClientResponse;

class ComplexResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $clientResponseMock;

    /**
     * @var ComplexResponse
     */
    private $response;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $headersMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $urlMock;

    protected function setUp()
    {
        $this->clientResponseMock = $this->getMockBuilder(ClientResponse::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlMock = $this->getMockBuilder(Url::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->headersMock = $this->getMockBuilder(Headers::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->response = new ComplexResponse($this->clientResponseMock, $this->urlMock);
    }

    protected function tearDown()
    {
        $this->clientResponseMock   = null;
        $this->urlMock              = null;
        $this->response             = null;
    }

    public function testGetBody()
    {
        $this->clientResponseMock
            ->expects($this->once())
            ->method('getBody')
            ->willReturn('{"id":123}');

        $this->assertEquals(['id' => 123], $this->response->getBody());
    }

    public function testGetCode()
    {
        $this->clientResponseMock
            ->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $this->assertEquals(200, $this->response->getCode());
    }

    public function testGetHeaders()
    {
        $this->headersMock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn([
                'Server'        => 'Apache',
                'Cache-Control' => 'no-cache',
                'Content-Type'  => 'application/pdf',
            ]);

        $this->clientResponseMock
            ->expects($this->once())
            ->method('getHeaders')
            ->willReturn($this->headersMock);

        $this->assertEquals([
            'Server'        => 'Apache',
            'Cache-Control' => 'no-cache',
            'Content-Type'  => 'application/pdf',

        ], $this->response->getHeaders());
    }

    public function testGetIdentifier()
    {
        $this->urlMock
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('http://google.com');

        $this->assertEquals('http://google.com', $this->response->getIdentifier());
    }

    public function testGetParams()
    {
        $this->urlMock
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('http://google.com');

        $this->assertEquals('http://google.com', $this->response->getIdentifier());
    }

    public function testGetResource()
    {
        $this->clientResponseMock
            ->expects($this->once())
            ->method('getBody')
            ->willReturn('{"id":123}');

        $this->assertEquals(123, $this->response->getResource('id'));
    }

    public function testIsClientError()
    {
        $this->clientResponseMock
            ->expects($this->once())
            ->method('isClientError')
            ->willReturn(true);

        $this->assertTrue($this->response->isClientError());
    }

    public function testIsServerError()
    {
        $this->clientResponseMock
            ->expects($this->once())
            ->method('isServerError')
            ->willReturn(true);

        $this->assertTrue($this->response->isServerError());
    }

    public function testIsSuccess()
    {
        $this->clientResponseMock
            ->expects($this->once())
            ->method('isSuccess')
            ->willReturn(true);

        $this->assertTrue($this->response->isSuccess());
    }
}