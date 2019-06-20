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

    public function testCurlOptUserAgent()
    {
        $this->assertEquals(null, $this->options->getCurlOptUserAgent());
        $this->assertFalse($this->options->hasCurlOptUserAgent());
        $this->options->setCurlOptUserAgent('UserAgent');
        $this->assertTrue($this->options->hasCurlOptUserAgent());
        $this->assertEquals('UserAgent', $this->options->getCurlOptUserAgent());
    }

    public function testTimeout()
    {
        $this->assertEquals(Options::DEFAULT_TIMEOUT, $this->options->getTimeout());

        $data = 30;

        $this->options->setTimeout($data);

        $this->assertEquals($data, $this->options->getTimeout());
    }

    public function testIsSimpleClientType()
    {
        $this->assertFalse($this->options->isSimpleClientType());
    }

    public function testUseComplexClientType()
    {
        $this->options->useComplexClientType();
        $this->assertFalse($this->options->isSimpleClientType());
    }

    public function testUseSimpleClientType()
    {
        $this->options->useSimpleClientType();
        $this->assertTrue($this->options->isSimpleClientType());
    }

    public function testIsSendParamsArrayType()
    {
        $this->assertTrue($this->options->isSendParamsArrayType());
    }

    public function testUseSendParamsArrayType()
    {
        $this->options->useSendParamsArrayType();
        $this->assertTrue($this->options->isSendParamsArrayType());
        $this->assertFalse($this->options->isSendParamsJsonType());
    }

    public function testUseSendParamsJsonType()
    {
        $this->options->useSendParamsJsonType();
        $this->assertTrue($this->options->isSendParamsJsonType());
        $this->assertFalse($this->options->isSendParamsArrayType());
    }
}