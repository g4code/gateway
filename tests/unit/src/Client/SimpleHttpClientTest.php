<?php

use G4\Gateway\Client\SimpleHttpClient;

class SimpleHttpClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SimpleHttpClient
     */
    private $client;

    private $urlValue = 'https://www.google.com';

    protected function setUp()
    {
        $this->client = new SimpleHttpClient();
    }

    protected function tearDown()
    {
        $this->client = null;
    }

    public function testSend()
    {
        echo "<pre>"; var_dump($this->client->send($this->urlMock(), $this->methodMock())); die;

        $this->assertEquals(

        );
    }

    private function urlMock()
    {
        $urlMock = $this->getMockBuilder('\G4\Gateway\Url')
            ->disableOriginalConstructor()
            ->getMock();

        $urlMock
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($this->urlValue);

        return $urlMock;
    }

    private function methodMock()
    {
        $methodMock = $this->getMockBuilder('\G4\Gateway\HttpMethod')
            ->disableOriginalConstructor()
            ->getMock();

        return $methodMock;
    }
}