<?php

namespace G4\Gateway;

use G4\Gateway\Client\HttpClientFactory;
use G4\Gateway\Client\HttpClientInterface;

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
     * @var \G4\Gateway\Response
     */
    private $response;

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
     * @return HttpClientInterface
     */
    public function makeClient()
    {
        return (new HttpClientFactory($this->options))->createClient();
    }

    public function patch(array $params = null)
    {
        return $this
            ->setMethodName(HttpMethod::PATCH)
            ->send($params);
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
     * @return FullRequestInfo
     */
    public function makeFullRequestInfo()
    {
        return new FullRequestInfo($this, $this->response);
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
     * @param $params
     * @return Response
     */
    private function send($params)
    {
        $client = $this->makeClient();
        $method = new HttpMethod($this->getMethodName());
        $url    = new Url($this->uri, $this->serviceName, new Params($params));

        $response       = $client->send($url, $method);
        $this->response = new Response($response);

        return $this->response;
    }
}