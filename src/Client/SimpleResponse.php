<?php

namespace G4\Gateway\Client;

use G4\Gateway\Url;
use \G4\Gateway\Params;
use G4\ValueObject\IntegerNumber;
use G4\ValueObject\StringLiteral;

class SimpleResponse implements ClientResponseInterface
{
    /**
     * @var string
     */
    private $body;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var IntegerNumber
     */
    private $statusCode;

    /**
     * @var Url
     */
    private $url;

    /**
     * SimpleResponse constructor.
     * @param $body
     * @param IntegerNumber $statusCode
     * @param Url $url
     */
    public function __construct($body, IntegerNumber $statusCode, Url $url)
    {
        $this->body        = $body;
        $this->statusCode  = $statusCode;
        $this->url         = $url;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        if(!is_array($this->body) && !empty($this->body)) {
            $decoded    = json_decode($this->body, true);
            $this->body = $decoded ? $decoded : $this->body;
        }

        return $this->body;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->statusCode->getValue();
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return (string) $this->url;
    }

    /**
     * @return Params
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
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return bool
     */
    public function isClientError()
    {
        return $this->statusCode->getValue() < 500 && $this->statusCode->getValue() >= 400;
    }

    /**
     * @return bool
     */
    public function isServerError()
    {
        return 500 <= $this->statusCode->getValue() && 600 > $this->statusCode->getValue();
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return 200 <= $this->statusCode->getValue() && 300 > $this->statusCode->getValue();
    }
}