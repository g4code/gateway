<?php

namespace G4\Gateway\Profiler;

class Ticker extends \G4\Profiler\Ticker\TickerAbstract
{

    private static $instance;

    private function __construct() {}

    private function __clone() {}


    /**
     * @return \G4\Gateway\Profiler\Ticker
     */
    final public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * @return Formatter
     */
    public function getDataFormatterInstance()
    {
        return new Formatter();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gateway';
    }

    /**
     * @param string $uniqueId
     * @param array $method
     * @return \G4\Gateway\Profiler\Ticker
     */
    public function setMethod($uniqueId, $method)
    {
        $this->getDataPart($uniqueId)->setMethod($method);
        return static::$instance;
    }

    /**
     * @param string $uniqueId
     * @param array $params
     * @return \G4\Gateway\Profiler\Ticker
     */
    public function setParams($uniqueId, $params)
    {
        $this->getDataPart($uniqueId)->setParams($params);
        return static::$instance;
    }

    /**
     * @param string $uniqueId
     * @param string $url
     * @return \G4\Gateway\Profiler\Ticker
     */
    public function setUrl($uniqueId, $url)
    {
        $this->getDataPart($uniqueId)->setUrl($url);
        return static::$instance;
    }
}