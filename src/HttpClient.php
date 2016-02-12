<?php

namespace G4\Gateway;

use G4\Gateway\Options;
use G4\Gateway\Method;

class HttpClient
{

    /**
     * @var \Zend\Http\Client
     */
    private $client;

    /**
     * @var Method
     */
    private $method;

    /**
     * @var Options
     */
    private $options;



    public function __construct(Options $options)
    {
        $this->options = $options;
        $this->client = $this->makeClient();
    }

    public function send()
    {
        $this->method->isPost()
            ? $this->client->setParameterPost($this->getHttpQueryParams())
            : $this->client->setParameterGet($this->getHttpQueryParams());

        $this->client
            ->setUri($this->buildUri())
            ->setMethod($this->method)
            ->send();

        $response = $this->client->getResponse();
    }

    public function setMethod(Method $method)
    {
        $this->method = $method;
    }


    public function makeClient()
    {
        $client = new \Zend\Http\Client();
        $client
            ->setAdapter('\Zend\Http\Client\Adapter\Curl')
            ->setEncType(\Zend\Http\Client::ENC_URLENCODED)
            ->setOptions([
                'timeout' => $this->options->getTimeout(),
                'curloptions' => [
                    CURLOPT_SSL_VERIFYPEER => $this->options->getSslVerifyPeer()
                ],
            ]);

        $client->getRequest()->getHeaders()->addHeaders($this->options->getHeaders());

        return $client;
    }
}