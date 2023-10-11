<?php

use G4\Gateway\Url;
use G4\ValueObject\IntegerNumber;
use G4\Gateway\Client\SimpleResponse;

class SimpleResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var SimpleResponse
     */
    private $response;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
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

    protected function setUp(): void
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

    protected function tearDown(): void
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

    public function testGetBodyWithSuccessStringResponse()
    {
        $this->body = 'success:OK';

        $response = new SimpleResponse($this->body, $this->statusCodeMock, $this->urlMock);
        $this->assertEquals('success:OK', $response->getBody());
    }

    public function testGetCode()
    {
        $this->assertEquals(200, $this->response->getCode());
    }

    public function testGetHeaders()
    {
        $this->response->setHeaders([
            'Content-Type' => 'application/json',
        ]);

        $this->assertEquals([
            'Content-Type' => 'application/json',
        ], $this->response->getHeaders());
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