<?php

use G4\Gateway\Client\SimpleHttpClient;

use G4\Gateway\Params;
use G4\Gateway\Options;

class SimpleHttpClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var SimpleHttpClient
     */
    private $client;

    /**
     * @var Options
     */
    private $optionsMock;

    /**
     * @var Params
     */
    private $paramsMock;


    private $urlValue = 'https://www.google.com';

    protected function setUp(): void
    {
        $this->optionsMock = $this->getMockBuilder('\G4\Gateway\Options')
        ->disableOriginalConstructor()
        ->getMock();

        $this->paramsMock = $this->getMockBuilder('\G4\Gateway\Params')
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new SimpleHttpClient($this->optionsMock);
    }

    protected function tearDown(): void
    {
        $this->client       = null;
        $this->optionsMock  = null;
    }

    public function testSend()
    {
        $this->assertInstanceOf(
            'G4\Gateway\Client\SimpleResponse',
            $this->client->send($this->urlMock(), $this->methodMock())
        );
    }

    public function testSendException()
    {
        $this->urlValue = 'fake-test-something-90274.com';
        $this->expectException('\Exception');
        $this->client->send($this->urlMock(), $this->methodMock());
    }

    private function urlMock()
    {
        $this->paramsMock
            ->expects($this->any())
            ->method('toArray')
            ->willReturn([]);

        $urlMock = $this->getMockBuilder('\G4\Gateway\Url')
            ->disableOriginalConstructor()
            ->getMock();

        $urlMock
            ->expects($this->any())
            ->method('getUri')
            ->willReturn($this->urlValue);

        $urlMock
            ->expects($this->any())
            ->method('getParams')
            ->willReturn($this->paramsMock);

        return $urlMock;
    }

    public function testGetHeaders()
    {
        $this->optionsMock
            ->expects($this->any())
            ->method('getHeaders')
            ->willReturn([
                'X-Auth-Email' => 'test@ctest.com',
                'X-Auth-Key'   => '54d9ab09fc6b97f892f7f687c0c32a9d28448',
                'Content-Type' => 'application/json'
            ]);

        $this->assertEquals([
                'X-Auth-Email: test@ctest.com',
                'X-Auth-Key: 54d9ab09fc6b97f892f7f687c0c32a9d28448',
                'Content-Type: application/json',
            ],
            $this->client->getHeaders()
        );
    }

    public function testGetEmptyHeaders()
    {
        $this->optionsMock
            ->expects($this->any())
            ->method('getHeaders')
            ->willReturn([]);

        $this->assertEquals([], $this->client->getHeaders());
    }

    private function methodMock()
    {
        $methodMock = $this->getMockBuilder('\G4\Gateway\HttpMethod')
            ->disableOriginalConstructor()
            ->getMock();
        $methodMock
            ->expects($this->any())
            ->method('isGet')
            ->willReturn(true);
        return $methodMock;
    }
}