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
        $data = [
            'Accept' => 'application/json',
        ];

        $this->options->setHeaders($data);

        $this->assertEquals($data, $this->options->getHeaders());
    }

    public function testUri()
    {
        $data = 'http://google.com';

        $this->options->setUri($data);

        $this->assertEquals($data, $this->options->getUri());
    }

    public function testResourceKey()
    {
        $data = 'resource';

        $this->options->setResourceKey($data);

        $this->assertEquals($data, $this->options->getResourceKey());
    }

    public function testSslVerifyPeer()
    {
        $this->assertNull($this->options->getSslVerifyPeer());

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