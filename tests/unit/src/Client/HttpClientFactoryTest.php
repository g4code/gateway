<?php

use G4\Gateway\Options;
use G4\Gateway\Client\HttpClientFactory;

class HttpClientFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Options
     */
    private $options;

    protected function setUp(): void
    {
        $this->options = new Options();
    }

    protected function tearDown(): void
    {
        $this->options = null;
    }

    public function testCreateComplexClient()
    {
        $this->assertInstanceOf(
            '\G4\Gateway\Client\ComplexHttpClient',
            $this->httpClientFactory()->createClient()
        );
    }

    public function testCreateComplexClientWithUseMethod()
    {
        $this->options->useComplexClientType();

        $this->assertInstanceOf(
            '\G4\Gateway\Client\ComplexHttpClient',
            $this->httpClientFactory()->createClient()
        );
    }

    public function testCreateSimpleClient()
    {
        $this->options->useSimpleClientType();

        $this->assertInstanceOf(
            '\G4\Gateway\Client\SimpleHttpClient',
            $this->httpClientFactory()->createClient()
        );
    }

    private function httpClientFactory()
    {
        return new HttpClientFactory($this->options);
    }
}