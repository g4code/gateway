<?php

use G4\Gateway\Http;

class HttpTest extends \PHPUnit_Framework_TestCase
{

    private $http;

    private $optionsMock;

    protected function setUp()
    {
//        $this->optionsMock = $this->getMockBuilder('\G4\Gateway\Options')
//            ->disableOriginalConstructor()
//            ->getMock();
//
//        $this->http = new Http($this->optionsMock);
    }

    protected function tearDown()
    {
        $this->optionsMock = null;
        $this->http = null;
    }

    public function testDelete()
    {
        
    }
}