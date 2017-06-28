<?php

use G4\Gateway\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $clientComplexResponseMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $clientSimpleResponseMock;

    /**
     * @var Response
     */
    private $complexResponse;

    /**
     * @var Response
     */
    private $simpleResponse;

    protected function setUp()
    {
        $this->clientComplexResponseMock = $this->getMockBuilder('\G4\Gateway\Client\ComplexResponse')
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientSimpleResponseMock = $this->getMockBuilder('\G4\Gateway\Client\SimpleResponse')
            ->disableOriginalConstructor()
            ->getMock();

        $this->complexResponse = new Response($this->clientComplexResponseMock);
        $this->simpleResponse  = new Response($this->clientSimpleResponseMock);
    }

    protected function tearDown()
    {
        $this->clientComplexResponseMock    = null;
        $this->clientSimpleResponseMock     = null;
        $this->complexResponse              = null;
        $this->simpleResponse               = null;
    }

    public function testGetBody()
    {
        $this->clientComplexResponseMock
            ->expects($this->once())
            ->method('getBody')
            ->willReturn('{"id":123}');

        $this->clientSimpleResponseMock
            ->expects($this->once())
            ->method('getBody')
            ->willReturn('{"id":123}');

        $this->assertEquals('{"id":123}', $this->complexResponse->getBody());
        $this->assertEquals('{"id":123}', $this->simpleResponse->getBody());
    }

    public function testGetCode()
    {
        $this->clientComplexResponseMock
            ->expects($this->once())
            ->method('getCode')
            ->willReturn(200);

        $this->clientSimpleResponseMock
            ->expects($this->once())
            ->method('getCode')
            ->willReturn(200);

        $this->assertEquals(200, $this->complexResponse->getCode());
        $this->assertEquals(200, $this->simpleResponse->getCode());
    }

    public function testGetHeaders()
    {
        $this->clientComplexResponseMock
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
            $this->complexResponse->getHeaders()
        );

        $this->clientSimpleResponseMock
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
            $this->simpleResponse->getHeaders()
        );
    }

    public function testGetIdentifier()
    {
        $this->clientComplexResponseMock
            ->expects($this->once())
            ->method('getIdentifier')
            ->willReturn('http://google.com');

        $this->clientSimpleResponseMock
            ->expects($this->once())
            ->method('getIdentifier')
            ->willReturn('http://google.com');

        $this->assertEquals('http://google.com', $this->complexResponse->getIdentifier());
        $this->assertEquals('http://google.com', $this->simpleResponse->getIdentifier());
    }

    public function testGetParams()
    {
        $this->clientComplexResponseMock
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
            $this->complexResponse->getParams()
        );

        $this->clientSimpleResponseMock
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
            $this->simpleResponse->getParams()
        );
    }

    public function testGetResource()
    {
        $this->clientComplexResponseMock
            ->expects($this->once())
            ->method('getResource')
            ->willReturn('123');

        $this->clientSimpleResponseMock
            ->expects($this->once())
            ->method('getResource')
            ->willReturn('123');

        $this->assertEquals(123, $this->complexResponse->getResource('id'));
        $this->assertEquals(123, $this->simpleResponse->getResource('id'));
    }

    public function testIsClientError()
    {
        $this->clientComplexResponseMock
            ->expects($this->once())
            ->method('isClientError')
            ->willReturn(true);

        $this->clientSimpleResponseMock
            ->expects($this->once())
            ->method('isClientError')
            ->willReturn(true);

        $this->assertTrue($this->complexResponse->isClientError());
        $this->assertTrue($this->simpleResponse->isClientError());
    }

    public function testIsServerError()
    {
        $this->clientComplexResponseMock
            ->expects($this->once())
            ->method('isServerError')
            ->willReturn(true);

        $this->clientSimpleResponseMock
            ->expects($this->once())
            ->method('isServerError')
            ->willReturn(true);

        $this->assertTrue($this->complexResponse->isServerError());
        $this->assertTrue($this->simpleResponse->isServerError());
    }

    public function testIsSuccess()
    {
        $this->clientComplexResponseMock
            ->expects($this->once())
            ->method('isSuccess')
            ->willReturn(true);

        $this->clientSimpleResponseMock
            ->expects($this->once())
            ->method('isSuccess')
            ->willReturn(true);

        $this->assertTrue($this->complexResponse->isSuccess());
        $this->assertTrue($this->simpleResponse->isSuccess());
    }
}