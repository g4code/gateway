<?php

namespace G4\Gateway;

class Options
{

    const DEFAULT_TIMEOUT = 10;

    /**
     * @var array
     */
    private $headers;


    /**
     * @var boolean
     */
    private $sslVerifyPeer;

    /**
     * @var int
     */
    private $timeout;


    public function __construct()
    {
        $this->headers = [];
    }

    /**
     * @return array:
     */
    public function getHeaders()
    {
        return array_filter($this->headers);
    }

    /**
     * @return bool
     */
    public function getSslVerifyPeer()
    {
        return $this->sslVerifyPeer !== null
            ? $this->sslVerifyPeer
            : true;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout === null
            ? self::DEFAULT_TIMEOUT
            : $this->timeout;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * @param boolean $value
     * @return \G4\Gateway\Options
     */
    public function setSslVerifyPeer($value)
    {
        $this->sslVerifyPeer = $value;
        return $this;
    }

    /**
     * @param int $timeout
     * @return \G4\Gateway\Options
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }
}