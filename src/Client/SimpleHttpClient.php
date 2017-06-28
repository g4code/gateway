<?php

namespace G4\Gateway\Client;

use G4\Gateway\Url;
use G4\Gateway\HttpMethod;
use G4\ValueObject\IntegerNumber;
use G4\ValueObject\StringLiteral;

class SimpleHttpClient implements HttpClientInterface
{
    /**
     * @param Url $url
     * @param HttpMethod $method
     * @return SimpleResponse
     */
    public function send(Url $url, HttpMethod $method)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL             => $url->getUri(),
            CURLOPT_HEADER          => true,
            CURLOPT_VERBOSE         => 1,
            CURLINFO_HEADER_OUT     => 1,
            CURLOPT_RETURNTRANSFER  => true,
        ]);

        $response = curl_exec($curl);
        $error    = curl_error($curl);

        list($header, $body) = explode("\r\n\r\n", $response, 2);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return (new SimpleResponse(new StringLiteral($body), new IntegerNumber($code), $url))
            ->setHeaders(new StringLiteral($header));
    }
}