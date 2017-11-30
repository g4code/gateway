<?php

namespace G4\Gateway;

class FullRequestInfoMap
{

    const REQUEST_HEADERS                    = 'request_headers';
    const RESPONSE_HEADERS                   = 'response_headers';
    const METHOD                             = 'method';
    const PARAMS                             = 'params';
    CONST RESPONSE                           = 'response';
    const STATUS_CODE                        = 'status_code';
    const URL                                = 'url';

    private $response;

    public function __construct(FullRequestInfo $response)
    {
        $this->response = $response;
    }

    public function map()
    {
        return [
            self::URL               => $this->response->getUrl(),
            self::METHOD            => $this->response->getMethodName(),
            self::STATUS_CODE       => $this->response->getStatusCode(),
            self::PARAMS            => $this->response->getParams()->toArray(),
            self::REQUEST_HEADERS   => $this->response->getRequestHeaders(),
            self::RESPONSE_HEADERS  => $this->response->getResponseHeaders(),
            self::RESPONSE          => $this->response->getResponseBody(),
        ];
    }
}