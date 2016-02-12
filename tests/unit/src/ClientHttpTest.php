<?php

use G4\Gateway\Client\ClientHttp;

class ClientHttpTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ClientHttp
     */
    private $client;

    private $optionsMock;

    protected function setUp()
    {
//        $this->optionsMock = $this->getMockBuilder('\G4\Gateway\Options')
//            ->disableOriginalConstructor()
//            ->getMock();
//
//        $this->client = new ClientHttp($this->optionsMock);
    }

    protected function tearDown()
    {
        $this->optionsMock = null;
        $this->client = null;
    }

    public function testMakeClient()
    {
//        $this->assertInstanceOf('\Zend\Http\Client', $this->client->makeClient());
    }
}