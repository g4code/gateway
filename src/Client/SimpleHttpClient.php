<?php

namespace G4\Gateway\Client;

use G4\Gateway\Url;
use G4\Gateway\HttpMethod;
use Zend\Http\Response;

class SimpleHttpClient implements HttpClientInterface
{
    /**
     * @param Url $url
     * @param HttpMethod $method
     * @return string
     */
    public function send(Url $url, HttpMethod $method)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL             => $url->getUri(),
            CURLOPT_RETURNTRANSFER  => true,
        ]);

        $response = curl_exec($curl);
        $error    = curl_error($curl);

        curl_close($curl);

        return $error
            ? "cURL Error #:" . $error
            : $response;
    }
}