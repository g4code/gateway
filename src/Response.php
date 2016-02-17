<?php

namespace G4\Gateway;

use Zend\Http\Response as ClientResponse;

class Response
{

    /**
     * @var ClientResponse
     */
    private $clientResponse;

    /**
     * @var array
     */
    private $body;

    /**
     * @var Url
     */
    private $url;


    public function __construct(ClientResponse $clientResponse, Url $url)
    {
        $this->clientResponse = $clientResponse;
        $this->url            = $url;

    }

    public function getBody()
    {
        if (!isset($this->body)) {
            $decoded = json_decode($this->clientResponse->getBody(), true);
            $this->body = $decoded
                ? $decoded
                : $this->response->getBody();
        }
        return $this->body;
    }

    public function getCode()
    {
        return $this->clientResponse->getStatusCode();
    }

    public function getIdentifier()
    {
        return (string) $this->url;
    }

    public function getResource($key)
    {
        $body = $this->getBody();
        return isset($body[$key])
            ? $body[$key]
            : null;
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