<?php

namespace G4\Gateway;

use G4\Gateway\HttpClient;
use G4\Gateway\HttpMethod;
use G4\Gateway\Params;


class Http
{

    /**
     * @var Options
     */
    private $options;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $serviceName;

    /**
     * Http constructor.
     * @param $uri
     * @param Options $options
     */
    public function __construct($uri, Options $options)
    {
        $this->uri     = $uri;
        $this->options = $options;
    }

    /**
     * @param array|null $params
     * @return Response
     */
    public function delete(array $params = null)
    {
        return $this->send(HttpMethod::DELETE, $params);
    }

    /**
     * @param array|null $params
     * @return Response
     */
    public function get(array $params = null)
    {
        return $this->send(HttpMethod::GET, $params);
    }

    /**
     * @return \G4\Gateway\HttpClient
     */
    public function makeClient()
    {
        return new HttpClient($this->options);
    }

    /**
     * @param array|null $params
     * @return Response
     */
    public function post(array $params = null)
    {
        return $this->send(HttpMethod::POST, $params);
    }

    /**
     * @param array|null $params
     * @return Response
     */
    public function put(array $params = null)
    {
        return $this->send(HttpMethod::PUT, $params);
    }

    /**
     * @param $serviceName
     * @return $this
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
        return $this;
    }

    /**
     * @param $methodName
     * @param $params
     * @return Response
     */
    private function send($methodName, $params)
    {
        $client = $this->makeClient();
        $method = new HttpMethod($methodName);
        $url    = new Url($this->uri, $this->serviceName, new Params($params));

        return $client->send($url, $method);
    }
}