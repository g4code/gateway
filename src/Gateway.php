<?php

namespace G4\Gateway;

class Gateway extends GatewayAbstract
{

    private $serviceName;

    private $httpMethod;

    private $httpQueryParams;

    public function getServiceName()
    {
        return $this->serviceName;
    }

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    public function getHttpQueryParams()
    {
        return $this->httpQueryParams === null
            ? []
            : $this->httpQueryParams;
    }

    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
        return $this;
    }

    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = $httpMethod;
        return $this;
    }

    public function setHttpQueryParams($httpQueryParams)
    {
        $this->httpQueryParams = $httpQueryParams;
        return $this;
    }
}