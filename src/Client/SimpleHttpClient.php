<?php

namespace G4\Gateway\Client;

use G4\Gateway\Url;
use G4\Gateway\Options;
use G4\Gateway\HttpMethod;
use G4\ValueObject\IntegerNumber;
use G4\ValueObject\StringLiteral;

class SimpleHttpClient implements HttpClientInterface
{
    /**
     * @var Options
     */
    private $options;

    /**
     * SimpleHttpClient constructor.
     * @param $options
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * @param Url $url
     * @param HttpMethod $method
     * @return SimpleResponse
     * @throws \Exception
     */
    public function send(Url $url, HttpMethod $method)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL             => $url->getUri(),
            CURLOPT_CUSTOMREQUEST   => $method,
            CURLOPT_HTTPHEADER      => $this->getHeaders(),
            CURLOPT_POSTFIELDS      => json_encode($url->getParams()->toArray()),
            CURLOPT_VERBOSE         => true,
            CURLINFO_HEADER_OUT     => true,
            CURLOPT_RETURNTRANSFER  => true,

        ]);

        $response = curl_exec($curl);
        $error    = curl_error($curl);
        $code     = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (!curl_errno($curl)) {
            return (new SimpleResponse(new StringLiteral($response), new IntegerNumber($code), $url))
                ->setHeaders($url->getParams()->toArray());
        }

        curl_close($curl);

        throw new \Exception($error, 500);
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = [];
        if(!empty($this->options->getHeaders())) {
            foreach($this->options->getHeaders() as $key => $value) {
                $headers[] = $key.': '.$value;
            }
        }

        return $headers;
    }
}