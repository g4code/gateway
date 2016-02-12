<?php

namespace G4\Gateway;

use G4\Gateway\HttpClient;


class Http
{

    /**
     * @var HttpClient
     */
    private $httpClient;


    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function delete()
    {
        return $this->send(HttpConst::METHOD_DELETE);
    }

    public function get()
    {
        return $this->send(HttpConst::METHOD_GET);
    }

    public function post()
    {
        return $this->send(HttpConst::METHOD_POST);
    }

    public function put()
    {
        return $this->send(HttpConst::METHOD_PUT);
    }

    public function setServiceName($serviceName)
    {
        $this->gateway->setServiceName($serviceName);
        return $this;
    }

    public function setHttpQueryParams($httpQueryParams)
    {
        $this->gateway->setHttpQueryParams($httpQueryParams);
        return $this;
    }

    private function send($method)
    {
        $this->gateway->setHttpMethod($method);
        $this->gateway->execute();
        return $this->gateway;
    }
}