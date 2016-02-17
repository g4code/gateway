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


    public function __construct($uri, Options $options)
    {
        $this->url     = $uri;
        $this->options = $options;
    }

    public function delete(array $params = null)
    {
        return $this
            ->send(HttpMethod::DELETE, $params);
    }

    public function get(array $params = null)
    {
        return $this
            ->send(HttpMethod::GET, $params);
    }

    public function makeClient()
    {
        return new HttpClient($this->options);
    }

    public function post(array $params = null)
    {
        return $this
            ->send(HttpMethod::POST, $params);
    }

    public function put(array $params = null)
    {
        return $this
            ->send(HttpMethod::PUT, $params);
    }

    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }

    private function send($methodName, $params)
    {
        $client = $this->makeClient();
        $method = new HttpMethod($methodName);
        $url    = new Url($this->uri, $this->serviceName, new Params($params));

        return $client->send($url, $method);
    }
}