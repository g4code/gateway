<?php

namespace G4\Gateway\Client;

use G4\Gateway\Url;
use G4\Gateway\Options;
use G4\Gateway\HttpMethod;
use G4\Gateway\Profiler\Ticker;
use G4\ValueObject\IntegerNumber;

class SimpleHttpClient implements HttpClientInterface
{

    /**
     * @var Options
     */
    private $options;

    private $imageTypes = [
        'image/png',
        'image/jpeg',
        'image/gif',
    ];

    /**
     * @var Ticker
     */
    private $profiler;

    /**
     * SimpleHttpClient constructor.
     * @param $options
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * @return Ticker
     */
    public function getProfiler()
    {
        if (!$this->profiler instanceof Ticker) {
            $this->profiler = Ticker::getInstance();
        }
        return $this->profiler;
    }

    /**
     * @param Url $url
     * @param HttpMethod $method
     * @return SimpleResponse
     * @throws \Exception
     */
    public function send(Url $url, HttpMethod $method)
    {
        $uniqueId = $this->getProfiler()->start();
        $curl     = curl_init();
        $uri      = $url->getUri();

        curl_setopt_array($curl, $this->getCurlOptions($url, $method));

        $response        = curl_exec($curl);
        $error           = curl_error($curl);
        $code            = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlErrorNumber = curl_errno($curl);

        $responseType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        if (in_array($responseType, $this->imageTypes)) {
            $response = $responseType;
        }

        curl_close($curl);

        $this->getProfiler()
             ->setUrl($uniqueId, $uri)
             ->setMethod($uniqueId, (string) $method)
             ->setParams($uniqueId, $url->getParams()->toArray())
             ->end($uniqueId);

        if ($curlErrorNumber == 0) {
            return (new SimpleResponse($response, new IntegerNumber($code), $url))
                ->setHeaders($url->getParams()->toArray());
        }

        throw new \Exception('Curl error: ' . $error, 500);
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = [];
        if (!empty($this->options->getHeaders())) {
            foreach ($this->options->getHeaders() as $key => $value) {
                $headers[] = $key . ': ' . $value;
            }
        }

        return $headers;
    }

    /**
     * @param Url $url
     * @param HttpMethod $method
     * @return array
     */
    private function getCurlOptions(Url $url, HttpMethod $method)
    {
        $options = [
            CURLOPT_URL            => $url->getUri(),
            CURLOPT_CUSTOMREQUEST  => (string) $method,
            CURLOPT_HTTPHEADER     => $this->getHeaders(),
            CURLOPT_VERBOSE        => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_TIMEOUT        => $this->options->getTimeout()
        ];

        $queryParams = http_build_query($url->getParams()->toArray());
        if ($method->isGet()) {
            $queryPart = empty($queryParams)
                ? ''
                : "?$queryParams";
            $options[CURLOPT_URL] = $url->getUri() . $queryPart;
        } else {
            $options[CURLOPT_POSTFIELDS] = $this->options->isSendParamsArrayType()
                ? $queryParams
                : $url->getParams()->toJson();
        }

        if ($this->options->hasCurlOptUserAgent()) {
            $options[CURLOPT_USERAGENT] = $this->options->getCurlOptUserAgent();
        }

        return $options;
    }
}
