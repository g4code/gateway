<?php

namespace G4\Gateway;

class FullRequestInfo
{
    /**
     * @var Http
     */
    private $http;

    /**
     * @var Response
     */
    private $response;

    /**
     * FullRequestInfo constructor.
     * @param Http $http
     * @param Response $response
     */
    public function __construct(Http $http, Response $response)
    {
        $this->http      = $http;
        $this->response  = $response;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->http->getMethodName();
    }

    /**
     * @return Params
     */
    public function getParams()
    {
        return $this->response->getParams();
    }

    /**
     * @return \Zend\Http\Headers
     */
    public function getResponseHeaders()
    {
        return $this->response->getHeaders();
    }

    /**
     * @return array
     */
    public function getRequestHeaders()
    {
        return $this->http->getHeaders();
    }

    /**
     * @return array|string
     */
    public function getResponseBody()
    {
        return $this->response->getBody();
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->response->getCode();
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->http->getUri();
    }
}