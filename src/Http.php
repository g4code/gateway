<?php

namespace G4\Gateway;

use G4\Gateway\HttpClient;
use G4\Gateway\HttpMethod;
use G4\Gateway\Params;


class Http
{
    /**
     * @var string
     */
    private $methodName;

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
        return $this
            ->setMethodName(HttpMethod::DELETE)
            ->send($params);
    }

    /**
     * @param array|null $params
     * @return Response
     */
    public function get(array $params = null)
    {
        return $this
            ->setMethodName(HttpMethod::GET)
            ->send($params);
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
        return $this
            ->setMethodName(HttpMethod::POST)
            ->send($params);
    }

    /**
     * @param array|null $params
     * @return Response
     */
    public function put(array $params = null)
    {
        return $this
            ->setMethodName(HttpMethod::PUT)
            ->send($params);
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
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->options->getHeaders();
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param $methodName
     * @return $this
     */
    private function setMethodName($methodName)
    {
        $this->methodName = $methodName;
        return $this;
    }

    /**
     * @param $methodName
     * @param $params
     * @return Response
     */
    private function send($params)
    {
        $client = $this->makeClient();
        $method = new HttpMethod($this->getMethodName());
        $url    = new Url($this->uri, $this->serviceName, new Params($params));

        return $client->send($url, $method);
    }
}