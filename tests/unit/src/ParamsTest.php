<?php

use G4\Gateway\Params;

class ParamsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var array
     */
    private $data;

    /**
     * @var Params
     */
    private $params;

    protected function setUp()
    {
        $this->data = [
            'id' => 123,
            'title' => 'this is title',
        ];
        $this->params = new Params($this->data);
    }

    protected function tearDown()
    {
        $this->data = null;
        $this->params = null;
    }

    public function testToArray()
    {
        $this->assertEquals($this->data, $this->params->toArray());
    }

    public function testWithValues()
    {
        $this->assertEquals('id=123&title=this+is+title', (string) $this->params);
    }

    public function testWithEmptyValues()
    {
        $params = new Params([]);
        $this->assertEquals('', (string) $params);
    }
}