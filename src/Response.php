<?php

namespace G4\Gateway;

use G4\Gateway\Client\ClientResponseInterface;

class Response
{
    /**
     * @var ClientResponseInterface
     */
    private $clientResponse;

    /**
     * Response constructor
     * @param ClientResponseInterface $clientResponse
     */
    public function __construct(ClientResponseInterface $clientResponse)
    {
        $this->clientResponse = $clientResponse;
    }

    public function getBody()
    {
       return $this->clientResponse->getBody();
    }

    public function getCode()
    {
        return $this->clientResponse->getCode();
    }

    public function getHeaders()
    {
        return $this->clientResponse->getHeaders();
    }

    public function getIdentifier()
    {
        return $this->clientResponse->getIdentifier();
    }

    public function getParams()
    {
        return $this->clientResponse->getParams();
    }

    public function getResource($key)
    {
        return $this->clientResponse->getResource($key);
    }

    public function isClientError()
    {
        return $this->clientResponse->isClientError();
    }

    public function isServerError()
    {
        return $this->clientResponse->isServerError();
    }

    public function isSuccess()
    {
        return $this->clientResponse->isSuccess();
    }
}