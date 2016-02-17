<?php

use G4\Gateway\Http;

class HttpTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Http
     */
    private $http;

    private $optionsMock;

    protected function setUp()
    {
        $this->optionsMock = $this->getMockBuilder('\G4\Gateway\Options')
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        $this->optionsMock = null;
        $this->http = null;
    }

    public function testDelete()
    {
        $this->setHttpMock();
        $this->assertInstanceOf('\G4\Gateway\Response', $this->http->delete([]));
    }

    public function testGet()
    {
        $this->setHttpMock();
        $this->assertInstanceOf('\G4\Gateway\Response', $this->http->get([]));
    }

    public function testPoste()
    {
        $this->setHttpMock();
        $this->assertInstanceOf('\G4\Gateway\Response', $this->http->post([]));
    }

    public function testPut()
    {
        $this->setHttpMock();
        $this->assertInstanceOf('\G4\Gateway\Response', $this->http->put([]));
    }

    public function testMakeClient()
    {
        $http = new Http('http://google.com', $this->optionsMock);

        $http->setServiceName('maps');

        $this->assertInstanceOf('\G4\Gateway\HttpClient', $http->makeClient());
    }

    private function setHttpMock()
    {
        $responseMock = $this->getMockBuilder('\G4\Gateway\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock = $this->getMockBuilder('\G4\Gateway\HttpClient')
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