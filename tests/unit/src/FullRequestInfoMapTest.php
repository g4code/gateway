<?php

use G4\Gateway\FullRequestInfo;
use G4\Gateway\FullRequestInfoMap;

class FullRequestInfoMapTest extends \PHPUnit\Framework\TestCase
{

    private $fullRequestInfoMock;

    private $url = 'https://hello.world';
    private $method = 'POST';
    private $statusCode = 200;
    private $params = ['request' => 'something'];
    private $requestHeaders = [];
    private $responseHeaders = ['response' => 'something'];
    private $responseBody = 'success';

    protected function setUp(): void
    {
        $this->fullRequestInfoMock = $this->getMockBuilder(FullRequestInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->fullRequestInfoMock->expects($this->once())->method('getUrl')->willReturn($this->url);
        $this->fullRequestInfoMock->expects($this->once())->method('getMethodName')->willReturn($this->method);
        $this->fullRequestInfoMock->expects($this->once())->method('getStatusCode')->willReturn($this->statusCode);
        $this->fullRequestInfoMock->expects($this->once())->method('getParams')->willReturn(new \G4\Gateway\Params($this->params));
        $this->fullRequestInfoMock->expects($this->once())->method('getRequestHeaders')->willReturn($this->requestHeaders);
        $this->fullRequestInfoMock->expects($this->once())->method('getResponseHeaders')->willReturn($this->responseHeaders);
        $this->fullRequestInfoMock->expects($this->once())->method('getResponseBody')->willReturn($this->responseBody);
    }

    protected function tearDown(): void
    {
        $this->fullRequestInfoMock = null;
    }

    public function testMap()
    {
        $this->assertEquals(
            [
                FullRequestInfoMap::URL               => $this->url,
                FullRequestInfoMap::METHOD            => $this->method,
                FullRequestInfoMap::STATUS_CODE       => $this->statusCode,
                FullRequestInfoMap::PARAMS            => $this->params,
                FullRequestInfoMap::REQUEST_HEADERS   => $this->requestHeaders,
                FullRequestInfoMap::RESPONSE_HEADERS  => $this->responseHeaders,
                FullRequestInfoMap::RESPONSE          => $this->responseBody,
            ],
            (new FullRequestInfoMap($this->fullRequestInfoMock))->map()
        );
    }
}