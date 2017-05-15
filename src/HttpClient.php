<?php

namespace G4\Gateway;

use G4\Gateway\Options;
use G4\Gateway\Params;
use G4\Gateway\HttpMethod;
use G4\Gateway\Profiler\Ticker;

class HttpClient
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
     * HttpClient constructor.
     * @param \G4\Gateway\Options $options
     */
    public function __construct(Options $options)
    {
        $this->options  = $options;
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
                    'curloptions' => [
                        CURLOPT_SSL_VERIFYPEER => $this->options->getSslVerifyPeer()
                    ],
                ]);

            $this->client->getRequest()->getHeaders()->addHeaders($this->options->getHeaders());
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
     * @param \G4\Gateway\HttpMethod $method
     * @return Response
     */
    public function send(Url $url, HttpMethod $method)
    {
        $uniqueId   = $this->getProfiler()->start();
        $uri        = $url->getUri();
        $params     = $url->getParams()->toArray();
        $httpMethod = (string) $method;

        $method->isPost()
            ? $this->getClient()->setParameterPost($params)
            : $this->getClient()->setParameterGet($params);

        $this->getClient()
            ->setUri($uri)
            ->setMethod($httpMethod)
            ->send();

        $this->getProfiler()
            ->setUrl($uniqueId, $uri)
            ->setMethod($uniqueId, $httpMethod)
            ->setParams($uniqueId, $params)
            ->end($uniqueId);

        return new Response($this->getClient()->getResponse(), $url);
    }
}