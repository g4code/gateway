<?php

use G4\Gateway\HttpMethod;

class HttpMethodTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var HttpMethod
     */
    private $httpMethod;

    protected function setUp(): void
    {
        $this->httpMethod = new HttpMethod(HttpMethod::PUT);
    }

    protected function tearDown(): void
    {
        $this->httpMethod = null;
    }

    public function testIsPost()
    {
        $this->assertTrue($this->httpMethod->isPost());

        $this->assertFalse((new HttpMethod(HttpMethod::GET))->isPost());
    }

    public function testValue()
    {
        $this->assertEquals(HttpMethod::PUT, (string) $this->httpMethod);
    }

    public function testException()
    {
        $this->expectException('\Exception', 'Http method is not valid', 101);

        new HttpMethod('not_a_method');
    }
}