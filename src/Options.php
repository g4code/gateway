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
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $resourceKey;

    /**
     * @var boolean
     */
    private $sslVerifyPeer;

    /**
     * @var int
     */
    private $timeout;


    /**
     * @return array:
     */
    public function getHeaders()
    {
        return array_filter($this->headers);
    }

    /**
     * @return string
     */
    public function getResourceKey()
    {
        return $this->resourceKey;
    }

    public function getSslVerifyPeer()
    {
        return $this->sslVerifyPeer;
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
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param array $headers
     * @return Options
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $resourceKey
     * @return Options
     */
    public function setResourceKey($resourceKey)
    {
        $this->resourceKey = $resourceKey;
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

    /**
     * @param string $uri
     * @return Options
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }
}