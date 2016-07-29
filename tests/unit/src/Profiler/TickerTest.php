<?php

use G4\Gateway\Profiler\Ticker;

class TickerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Ticker
     */
    private $ticker;

    protected function setUp()
    {
        $this->ticker = Ticker::getInstance();
    }

    protected function tearDown()
    {
        $this->ticker = null;
    }

    public function testGetDataFormatterInstance()
    {
        $this->assertInstanceOf('\G4\Gateway\Profiler\Formatter', $this->ticker->getDataFormatterInstance());
    }

    public function testGetName()
    {
        $this->assertEquals('gateway', $this->ticker->getName());
    }

    public function testSetMethod()
    {
        $uniqueId       = md5(time());
        $methodValue    = 'GET';

            $this->assertInstanceOf(
            '\G4\Gateway\Profiler\Ticker',
            $this->tickerMockFactory($uniqueId, 'setMethod', $methodValue)->setMethod($uniqueId, $methodValue));
    }

    public function testSetParams()
    {
        $uniqueId       = md5(time());
        $methodValue    = ['id' => 456];

        $this->assertInstanceOf(
            '\G4\Gateway\Profiler\Ticker',
            $this->tickerMockFactory($uniqueId, 'setParams', $methodValue)->setParams($uniqueId, $methodValue)
        );
    }

    public function testSetUrl()
    {
        $uniqueId       = md5(time());
        $methodValue    = 'http://google.com';

        $this->assertInstanceOf(
            '\G4\Gateway\Profiler\Ticker',
            $this->tickerMockFactory($uniqueId, 'setUrl', $methodValue)->setUrl($uniqueId, $methodValue)
        );
    }

    private function tickerMockFactory($uniqueId, $formatterMethodName, $methodValue)
    {
        $formatterMock = $this->getMockBuilder('\G4\Gateway\Profiler\Formatter')
            ->disableOriginalConstructor()
            ->setMethods([$formatterMethodName])
            ->getMock();

        $formatterMock
            ->expects($this->once())
            ->method($formatterMethodName)
            ->with($methodValue);

        $tickerMock = $this->getMockBuilder('\G4\Gateway\Profiler\Ticker')
            ->disableOriginalConstructor()
            ->setMethods(['getDataPart'])
            ->getMock();

        $tickerMock
            ->expects($this->once())
            ->method('getDataPart')
            ->with($uniqueId)
            ->willReturn($formatterMock);

        return $tickerMock;
    }
}