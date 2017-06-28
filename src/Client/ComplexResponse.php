<?php

namespace G4\Gateway\Client;

use G4\Gateway\Url;
use Zend\Http\Response as ClientResponse;

class ComplexResponse implements ClientResponseInterface
{
    /**
     * @var ClientResponse
     */
    private $clientResponse;

    /**
     * @var Url
     */
    private $url;

    /**
     * ComplexResponse constructor.
     * @param ClientResponse $clientResponse
     * @param Url $url
     */
    public function __construct(ClientResponse $clientResponse, Url $url)
    {
        $this->clientResponse  = $clientResponse;
        $this->url             = $url;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        if (!isset($this->body)) {
            $body       = $this->clientResponse->getBody();
            $decoded    = json_decode($body, true);
            $this->body = $decoded ? $decoded : $body;
        }
        return $this->body;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->clientResponse->getStatusCode();
    }

    /**
     * @return \Zend\Http\Headers
     */
    public function getHeaders()
    {
        return $this->clientResponse->getHeaders();
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return (string) $this->url;
    }

    /**
     * @return \G4\Gateway\Params
     */
    public function getParams()
    {
        return $this->url->getParams();
    }

    /**
     * @param $key
     * @return string|null
     */
    public function getResource($key)
    {
        $body = $this->getBody();
        return isset($body[$key])
            ? $body[$key]
            : null;
    }

    /**
     * @return bool
     */
    public function isClientError()
    {
        return $this->clientResponse->isClientError();
    }

    /**
     * @return bool
     */
    public function isServerError()
    {
        return $this->clientResponse->isServerError();
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->clientResponse->isSuccess();
    }
}