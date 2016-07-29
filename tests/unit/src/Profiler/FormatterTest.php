<?php

use G4\Gateway\Profiler\Formatter;

class FormatterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Formatter
     */
    private $formatter;

    protected function setUp()
    {
        $timerMock = $this->getMockBuilder('\G4\Profiler\Ticker\Timer')
            ->disableOriginalConstructor()
            ->setMethods(['getElapsed'])
            ->getMock();

        $timerMock
            ->expects($this->once())
            ->method('getElapsed')
            ->willReturn(123);

        $this->formatter = $this->getMockBuilder('\G4\Gateway\Profiler\Formatter')
            ->disableOriginalConstructor()
            ->setMethods(['getFormattedTime', 'getTimer'])
            ->getMock();

        $this->formatter
            ->expects($this->once())
            ->method('getFormattedTime')
            ->willReturn(123);

        $this->formatter
            ->expects($this->once())
            ->method('getTimer')
            ->willReturn($timerMock);
    }

    protected function tearDown()
    {
        $this->formatter = null;
    }

    public function testGetFormatted()
    {
        $this->formatter
            ->setMethod('GET')
            ->setParams(['id' => 987])
            ->setUrl('http://google.com');

        $this->assertEquals([
                'elapsed_time'  => 123,
                'url'           => 'http://google.com',
                'method'        => 'GET',
                'params'        => ['id' => 987],
            ], $this->formatter->getFormatted());
    }
}