<?php

namespace G4\Gateway;

use G4\Constants\Http as HttpConst;

abstract class GatewayAbstract implements GatewayInterface
{

    /**
     * @var \Zend\Http\Client
     */
    private $httpClient;

    /**
     * @var Options
     */
    private $options;

    /**
     * @var array
     */
    private $params;

    /**
     * @var \Zend\Http\Response
     */
    private $response;

    /**
     * @var array
     */
    private $responseBody;


    public function __construct(Options $options)
    {
        $this->options = $options;
        $this->initHttpClient();
    }

    public function execute()
    {
        $this->shouldSetParameterPost()
            ? $this->httpClient->setParameterPost($this->getHttpQueryParams())
            : $this->httpClient->setParameterGet($this->getHttpQueryParams());

        $this->httpClient
            ->setUri($this->buildUri())
            ->setMethod($this->getHttpMethod())
            ->send();

        $this->response = $this->httpClient->getResponse();
    }

    /**
     * @return \Zend\Http\Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->buildUri() . '?' . http_build_query($this->getHttpQueryParams());
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getParams($key = null)
    {
       return $key === null
            ? $this->params
            : $this->getParamsByKey($key);

    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        $responseBody = $this->getResponseBody();
        return isset($responseBody[$this->options->getResourceKey()])
            ? $responseBody[$this->options->getResourceKey()]
            : null;
    }

    /**
     * @return array
     */
    public function getResponseBody()
    {
        if (!isset($this->responseBody)) {
            $decoded = json_decode($this->response->getBody(), true);
            $this->responseBody = $decoded
                ? $decoded
                : $this->response->getBody();
        }
        return $this->responseBody;
    }

    /**
     * @return int
     */
    public function getResponseCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return boolean
     */
    public function isOk()
    {
        return $this->getResponseCode() >= HttpConst::CODE_200
            && $this->getResponseCode() < HttpConst::CODE_300;
    }

    /**
     * @param array $params
     * @return GatewayAbstract
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return string
     */
    private function buildUri()
    {
        return $this->options->getUri() . '/' . $this->getServiceName();
    }

    /**
     * @param string $key
     * @return mixed
     */
    private function getParamsByKey($key)
    {
        return isset($this->params[$key])
            ? $this->params[$key]
            : null;
    }

    private function initHttpClient()
    {
        $this->httpClient = new \Zend\Http\Client();
        $this->httpClient->setAdapter('\Zend\Http\Client\Adapter\Curl');
        $this->httpClient->setEncType(\Zend\Http\Client::ENC_URLENCODED);
        $this->httpClient->setOptions([
            'timeout' => $this->options->getTimeout(),
            'curloptions' => [
                CURLOPT_SSL_VERIFYPEER => $this->options->getSslVerifyPeer()  !== null ? $this->options->getSslVerifyPeer() : true],
        ]);
        $this->httpClient->getRequest()->getHeaders()->addHeaders($this->options->getHeaders());
    }

    /**
     * @return boolean
     */
    private function shouldSetParameterPost()
    {
        return in_array($this->getHttpMethod(), [HttpConst::METHOD_POST, HttpConst::METHOD_PUT]);
    }
}