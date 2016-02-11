<?php

use G4\Gateway\Options;

class OptionsTest extends \PHPUnit_Framework_TestCase
{

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

    }
}