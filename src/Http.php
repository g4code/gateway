<?php

namespace G4\Gateway;

use \G4\Constants\Http as HttpConst;

class Http
{

    private $gateway;

    public function __construct()
    {
        $this->gateway = new Gateway();
    }

    public function delete()
    {
        return $this->execute(HttpConst::METHOD_DELETE);
    }

    public function get()
    {
        return $this->execute(HttpConst::METHOD_GET);
    }

    public function post()
    {
        return $this->execute(HttpConst::METHOD_POST);
    }

    public function put()
    {
        return $this->execute(HttpConst::METHOD_PUT;
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

    private function execute($method)
    {
        $this->gateway->setHttpMethod($method);
        $this->gateway->execute();
        return $this->gateway;
    }
}