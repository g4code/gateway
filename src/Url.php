<?php

namespace G4\Gateway;

class Url
{

    /**
     * @var string
     */
    private $uri;

    /**
     * @var Params
     */
    private $params;

    /**
     * @var string
     */
    private $serviceName;

    /**
     * Url constructor.
     * @param $uri
     * @param null $serviceName
     * @param Params $params
     * @throws \Exception
     */
    public function __construct($uri, $serviceName = null, Params $params = null)
    {
        if (empty($uri) || !is_string($uri)) {
            throw new \InvalidArgumentException('Uri is not a string!', 101);
        }
        $this->uri         = $uri;
        $this->serviceName = $serviceName;
        $this->params      = $params instanceof Params ? $params : new Params();
    }

    public function __toString()
    {
        $params = (string) $this->params;
        return $params === ''
            ? $this->getUri()
            : $this->getUri() . '?' . $params;
    }

    /**
     * @return Params
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->serviceName === null
            ? $this->uri
            : $this->uri . '/' .  $this->getServiceName();
    }

    /**
     * @return string
     */
    private function getServiceName()
    {
        return $this->serviceName === null
            ? ''
            : $this->serviceName;
    }
}