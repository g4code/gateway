<?php

use G4\Gateway\Url;

class UrlTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $paramsMock;

    /**
     * @var Url
     */
    private $url;

    protected function setUp()
    {
        $this->paramsMock = $this->getMockBuilder('\G4\Gateway\Params')
            ->disableOriginalConstructor()
            ->getMock();

        $this->url = new Url('http://google.com', 'service', $this->paramsMock);
    }

    protected function tearDown()
    {
        $this->paramsMock = null;
        $this->url = null;
    }

    public function testGetUri()
    {
        $this->assertEquals('http://google.com/service', $this->url->getUri());
    }

    public function testToString()
    {
        $this->paramsMock
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('id=123');

        $this->assertEquals('http://google.com/service?id=123', (string) $this->url);
    }

    public function testGetParams()
    {
        $this->assertEquals($this->paramsMock, $this->url->getParams());
    }
}