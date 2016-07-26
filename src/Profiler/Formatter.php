<?php

namespace G4\Gateway\Profiler;

class Formatter extends \G4\Profiler\Ticker\Formatter
{

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $url;


    /**
     * @return array
     */
    public function getFormatted()
    {
        return parent::getFormatted()
        + [
            'url'       => $this->url,
            'method'    => $this->method,
            'params'    => $this->params,
        ];
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param array $params
     * @return \G4\Gateway\Profiler\Formatter
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param string $hit
     * @return \G4\Gateway\Profiler\Formatter
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
}