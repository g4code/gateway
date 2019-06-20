<?php

namespace G4\Gateway\Client;

use G4\Gateway\Url;
use G4\Gateway\Options;
use G4\Gateway\HttpMethod;
use G4\Gateway\Profiler\Ticker;

class ComplexHttpClient implements HttpClientInterface
{
    /**
     * @var \Zend\Http\Client
     */
    private $client;

    /**
     * @var Options
     */
    private $options;

    /**
     * @var Ticker
     */
    private $profiler;

    /**
     * ComplexHttpClient constructor.
     * @param Options $options
     */
    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    /**
     * @return \Zend\Http\Client
     */
    public function getClient()
    {
        if (! $this->client instanceof \Zend\Http\Client) {

            $this->client = new \Zend\Http\Client();
            $this->client
                ->setAdapter('\Zend\Http\Client\Adapter\Curl')
                ->setEncType(\Zend\Http\Client::ENC_URLENCODED)
                ->setOptions([
                    'timeout' => $this->options->getTimeout(),
                    'curloptions' => $this->getCurlOptions(),
                ]);

            $this->client->getRequest()->getHeaders()->addHeaders($this->options->getHeaders());

            if ($auth = $this->options->getAuth()) {
                $this->client->setAuth($auth['username'], $auth['password']);
            }
        }

        return $this->client;
    }

    /**
     * @return Ticker
     */
    public function getProfiler()
    {
        if (! $this->profiler instanceof Ticker) {
            $this->profiler = Ticker::getInstance();
        }
        return $this->profiler;
    }

    /**
     * @param Url $url
     * @param HttpMethod $method
     * @return ComplexResponse
     */
    public function send(Url $url, HttpMethod $method)
    {
        $uniqueId   = $this->getProfiler()->start();
        $uri        = $url->getUri();
        $params     = $url->getParams()->toArray();
        $httpMethod = (string) $method;

        $isPost = $method->isPost();
        if ($isPost) {
            $this->getClient()->setParameterPost($params);

            if ($this->options->isSendParamsJsonType()) {
                $this->getClient()->setRawBody(json_encode($params));
            }
        }
        if (!$isPost) {
            $this->getClient()->setParameterGet($params);
        }

        $this->getClient()
            ->setUri($uri)
            ->setMethod($httpMethod)
            ->send();

        $this->getProfiler()
            ->setUrl($uniqueId, $uri)
            ->setMethod($uniqueId, $httpMethod)
            ->setParams($uniqueId, $params)
            ->end($uniqueId);

        return new ComplexResponse($this->getClient()->getResponse(), $url);
    }

    /**
     * @return array
     */
    private function getCurlOptions()
    {
        $curlOptions = [
            CURLOPT_SSL_VERIFYPEER => $this->options->getSslVerifyPeer()
        ];

        if ($this->options->hasCurlOptUserAgent()) {
            $curlOptions[CURLOPT_USERAGENT] = $this->options->getCurlOptUserAgent();
        }

        return $curlOptions;
    }
}