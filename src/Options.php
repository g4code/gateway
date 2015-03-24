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
     * @var array
     */
    private $params;


    public function __construct()
    {
        $this->params = [];
    }

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

    public function hasParam($name)
    {
        return isset($this->params[$name]);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getParam($name)
    {
        return $this->hasParameter($name) ? $this->params[$name] : null;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
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

    /**
     * @param string $name
     * @param mixed $value
     * @return Options
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * @param array $params
     * @return Options
     */
    public function setParams($params)
    {
        foreach ($params as $name => $value) {
            $this->setParam($name, $value);
        }
        return $this;
    }
}