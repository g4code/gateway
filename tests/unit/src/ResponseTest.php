<?php

use G4\Gateway\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $clientResponseMock;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $urlMock;

    protected function setUp()
    {
        $this->clientResponseMock = $this->getMockBuilder('\Zend\Http\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlMock = $this->getMockBuilder('\G4\Gateway\Url')
            ->disableOriginalConstructor()
            ->getMock();

        $this->response = new Response($this->clientResponseMock, $this->urlMock);
    }

    protected function tearDown()
    {
        $this->clientResponseMock = null;
        $this->urlMock = null;
        $this->response = null;
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
        $this->clientResponseMock
            ->expects($this->once())
            ->method('getHeaders')
            ->willReturn([
                'Server'        => 'Apache',
                'Cache-Control' => 'no-cache',
                'Content-Type'  => 'application/pdf',
            ]);

        $this->assertEquals(
            [
                'Server'        => 'Apache',
                'Cache-Control' => 'no-cache',
                'Content-Type'  => 'application/pdf',
            ],
            $this->response->getHeaders()
        );
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
            ->method('getParams')
            ->willReturn([
                'domain' => 'www.test.com',
                'ip'     => '192.192.192.192'
            ]);

        $this->assertEquals(
            [
                'domain' => 'www.test.com',
                'ip'     => '192.192.192.192'
            ],
            $this->response->getParams()
        );
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