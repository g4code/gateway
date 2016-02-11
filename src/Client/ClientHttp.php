<?php

namespace G4\Gateway\Client;

use G4\Gateway\Options;

class ClientHttp
{

    private $client;

    private $options;

    public function __construct(Options $options)
    {
        $this->options = $options;
        $this->client = $this->makeClient();
    }


    public function makeClient()
    {
        $client = new \Zend\Http\Client();
        $client
            ->setAdapter('\Zend\Http\Client\Adapter\Curl')
            ->setEncType(\Zend\Http\Client::ENC_URLENCODED);

        return $client;
    }


}