<?php

namespace G4\Gateway;

class Options
{

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
     * @return array:
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getResourceKey()
    {
        return $this->resourceKey;
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
     * @param string $uri
     * @return Options
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }
}