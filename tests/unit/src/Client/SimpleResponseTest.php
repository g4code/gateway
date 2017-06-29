<?php

use G4\Gateway\Url;
use G4\ValueObject\IntegerNumber;
use G4\Gateway\Client\SimpleResponse;

class SimpleResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SimpleResponse
     */
    private $response;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $urlMock;

    /**
     * @var string
     */
    private $body;

    /**
     * @var IntegerNumber
     */
    private $statusCodeMock;

    protected function setUp()
    {
        $this->urlMock = $this->getMockBuilder(Url::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlMock
            ->expects($this->any())
            ->method('__toString')
            ->willReturn('http://google.com');

        $this->statusCodeMock = $this->getMockBuilder(IntegerNumber::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->statusCodeMock
            ->expects($this->any())
            ->method('getValue')
            ->willReturn(200);

        $this->response = new SimpleResponse($this->body, $this->statusCodeMock, $this->urlMock);
    }

    protected function tearDown()
    {
        $this->urlMock          = null;
        $this->statusCodeMock   = null;
    }

    public function testGetBodyWithJson()
    {
        $this->body = '{"id":123}';

        $response = new SimpleResponse($this->body, $this->statusCodeMock, $this->urlMock);
        $this->assertEquals(['id' => 123], $response->getBody());
    }

    public function testGetBodyWithEmptyString()
    {
        $this->body = '';

        $response = new SimpleResponse($this->body, $this->statusCodeMock, $this->urlMock);
        $this->assertEquals('', $response->getBody());
    }

    public function testGetBodyWithEmptyArray()
    {
        $this->body = [];

        $response = new SimpleResponse($this->body, $this->statusCodeMock, $this->urlMock);
        $this->assertEquals([], $response->getBody());
    }

    public function testGetCode()
    {
        $this->assertEquals(200, $this->response->getCode());
    }

    public function testGetIdentifier()
    {
        $this->assertEquals('http://google.com', $this->response->getIdentifier());
    }

    public function testGetResourceWithJsonBody()
    {
        $this->body = '{"id":123}';

        $response = new SimpleResponse($this->body, $this->statusCodeMock, $this->urlMock);
        $this->assertEquals(123, $response->getResource('id'));
    }

    public function testGetResourceWithEmptyBody()
    {
        $this->body = '';

        $response = new SimpleResponse($this->body, $this->statusCodeMock, $this->urlMock);
        $this->assertEquals(null, $response->getResource('id'));
    }

    public function testIsClientError()
    {
        $this->assertFalse($this->response->isClientError());
    }

    public function testIsServerError()
    {
        $this->assertFalse($this->response->isServerError());
    }

    public function testIsSuccess()
    {
        $this->assertTrue($this->response->isSuccess());
    }
}