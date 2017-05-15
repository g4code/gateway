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
    public function __construct($uri, $serviceName = null, Params $params)
    {
        if (empty($uri) || !is_string($uri)) {
            throw new \Exception('Uri is not a string!', 101);
        }
        $this->uri         = $uri;
        $this->serviceName = $serviceName;
        $this->params      = $params;
    }

    public function __toString()
    {
        return $this->getUri() . '?' . (string) $this->params;
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
        return $this->uri . '/' .  $this->getServiceName();
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