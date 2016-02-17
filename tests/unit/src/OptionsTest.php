<?php

use G4\Gateway\Options;

class OptionsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Options
     */
    private $options;

    protected function setUp()
    {
        $this->options = new Options();
    }

    protected function tearDown()
    {
        $this->options = null;
    }

    public function testHeaders()
    {
        $this->options->addHeader('Accept', 'application/json');

        $this->assertEquals(['Accept' => 'application/json'], $this->options->getHeaders());
    }

    public function testSslVerifyPeer()
    {
        $this->assertTrue($this->options->getSslVerifyPeer());

        $this->options->setSslVerifyPeer(true);

        $this->assertTrue($this->options->getSslVerifyPeer());
    }

    public function testTimeout()
    {
        $this->assertEquals(Options::DEFAULT_TIMEOUT, $this->options->getTimeout());

        $data = 30;

        $this->options->setTimeout($data);

        $this->assertEquals($data, $this->options->getTimeout());
    }
}