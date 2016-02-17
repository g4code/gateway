<?php

namespace G4\Gateway;

use G4\Gateway\Options;
use G4\Gateway\Params;
use G4\Gateway\HttpMethod;

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




    public function __construct(Options $options)
    {
        $this->options = $options;
        $this->client  = $this->makeClient();
    }

    public function send(Url $url, HttpMethod $method)
    {
        $method->isPost()
            ? $this->client->setParameterPost((string) $url->getParams())
            : $this->client->setParameterGet((string) $url->getParams());

        $this->client
            ->setUri($url->getUri())
            ->setMethod((string) $method)
            ->send();

        return new Response($this->client->getResponse(), $url);
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