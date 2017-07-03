<?php

use G4\Gateway\Http;
use G4\Gateway\Options;
use G4\Gateway\HttpMethod;

class HttpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Http
     */
    private $complexHttp;

    /**
     * @var Http
     */
    private $simpleHttp;

    /**
     * @var Options
     */
    private $optionsMock;

    protected function setUp()
    {
        $this->optionsMock = $this->getMockBuilder('\G4\Gateway\Options')
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        $this->optionsMock  = null;
        $this->complexHttp  = null;
    }

    public function testDelete()
    {
        $this->setComplexHttpMock();
        $this->assertInstanceOf('\G4\Gateway\Response', $this->complexHttp->delete([]));

        $this->setSimpleHttpMock();
        $this->assertInstanceOf('\G4\Gateway\Response', $this->simpleHttp->delete([]));
    }

    public function testGet()
    {
        $this->setComplexHttpMock();
        $this->assertInstanceOf('\G4\Gateway\Response', $this->complexHttp->get([]));

        $this->setSimpleHttpMock();
        $this->assertInstanceOf('\G4\Gateway\Response', $this->simpleHttp->get([]));
    }

    public function testPost()
    {
        $this->setComplexHttpMock();
        $this->assertInstanceOf('\G4\Gateway\Response', $this->complexHttp->post([]));

        $this->setSimpleHttpMock();
        $this->assertInstanceOf('\G4\Gateway\Response', $this->simpleHttp->post([]));
    }

    public function testPut()
    {
        $this->setComplexHttpMock();
        $this->assertInstanceOf('\G4\Gateway\Response', $this->complexHttp->put([]));

        $this->setSimpleHttpMock();
        $this->assertInstanceOf('\G4\Gateway\Response', $this->simpleHttp->put([]));
    }

    public function testMakeComplexClient()
    {
        $this->optionsMock
            ->expects($this->any())
            ->method('getHeaders')
            ->willReturn([
                'Server'        => 'Apache',
                'Cache-Control' => 'no-cache',
                'Content-Type'  => 'application/pdf',
            ]);

        $http = new Http('http://google.com', $this->optionsMock);

        $http->setServiceName('maps');

        $this->assertInstanceOf('\G4\Gateway\Client\ComplexHttpClient', $http->makeClient());
    }

    public function testMakeComplexClientWithUseMethod()
    {
        $this->optionsMock
            ->expects($this->once())
        ->method('isSimpleClientType')
        ->willReturn(false);

        $http = new Http('http://google.com', $this->optionsMock);

        $http->setServiceName('maps');

        $this->assertInstanceOf('\G4\Gateway\Client\ComplexHttpClient', $http->makeClient());
    }

    public function testMakeSimpleClient()
    {
        $this->optionsMock
            ->expects($this->any())
            ->method('getHeaders')
            ->willReturn([
                'Server'        => 'Apache',
                'Cache-Control' => 'no-cache',
                'Content-Type'  => 'application/pdf',
            ]);

        $this->optionsMock
            ->expects($this->once())
            ->method('isSimpleClientType')
            ->willReturn(true);

        $http = new Http('http://google.com', $this->optionsMock);

        $http->setServiceName('maps');

        $this->assertInstanceOf('\G4\Gateway\Client\SimpleHttpClient', $http->makeClient());
    }

    public function testMakeFullRequestInfo()
    {
        $this->setComplexHttpMock();
        $this->complexHttp->post([]);
        $this->assertInstanceOf('\G4\Gateway\FullRequestInfo', $this->complexHttp->makeFullRequestInfo());

        $this->setSimpleHttpMock();
        $this->simpleHttp->post([]);
        $this->assertInstanceOf('\G4\Gateway\FullRequestInfo', $this->simpleHttp->makeFullRequestInfo());
    }

    public function testGetMethodName()
    {
        $this->setComplexHttpMock();
        $this->complexHttp->post([]);
        $this->assertEquals(HttpMethod::POST, $this->complexHttp->getMethodName());
        $this->assertNotEquals(HttpMethod::PUT, $this->complexHttp->getMethodName());
        $this->assertNotEquals(HttpMethod::GET, $this->complexHttp->getMethodName());
        $this->assertNotEquals(HttpMethod::DELETE, $this->complexHttp->getMethodName());

        $this->setSimpleHttpMock();
        $this->simpleHttp->post([]);
        $this->assertEquals(HttpMethod::POST, $this->simpleHttp->getMethodName());
        $this->assertNotEquals(HttpMethod::PUT, $this->simpleHttp->getMethodName());
        $this->assertNotEquals(HttpMethod::GET, $this->simpleHttp->getMethodName());
        $this->assertNotEquals(HttpMethod::DELETE, $this->simpleHttp->getMethodName());
    }

    public function testGetHeaders()
    {
        $this->optionsMock
            ->expects($this->once())
            ->method('getHeaders')
            ->willReturn([
                'Server'        => 'Apache',
                'Cache-Control' => 'no-cache',
                'Content-Type'  => 'application/pdf',
            ]);

        $http = new Http('http://google.com', $this->optionsMock);
        $this->assertEquals(
            [
                'Server'        => 'Apache',
                'Cache-Control' => 'no-cache',
                'Content-Type'  => 'application/pdf',
            ],
            $http->getHeaders()
        );
    }

    public function testGetUri()
    {
        $http = new Http('http://google.com', $this->optionsMock);
        $this->assertEquals('http://google.com', $http->getUri());
    }

    private function setComplexHttpMock()
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

        $this->complexHttp = $this->getMockBuilder('\G4\Gateway\Http')
            ->setConstructorArgs(['http://google.com', $this->optionsMock])
            ->setMethods(['makeClient'])
            ->getMock();

        $this->complexHttp
            ->expects($this->once())
            ->method('makeClient')
            ->willReturn($clientMock);
    }

    private function setSimpleHttpMock()
    {
        $responseMock = $this->getMockBuilder('\G4\Gateway\Client\SimpleResponse')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock = $this->getMockBuilder('\G4\Gateway\Client\SimpleHttpClient')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock
            ->expects($this->once())
            ->method('send')
            ->willReturn($responseMock);

        $this->simpleHttp = $this->getMockBuilder('\G4\Gateway\Http')
            ->setConstructorArgs(['http://google.com', $this->optionsMock])
            ->setMethods(['makeClient'])
            ->getMock();

        $this->simpleHttp
            ->expects($this->once())
            ->method('makeClient')
            ->willReturn($clientMock);
    }
}