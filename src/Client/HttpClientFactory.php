<?php

namespace G4\Gateway\Client;

use G4\Gateway\Options;

class HttpClientFactory
{
    /**
     * @var Options
     */
    private $options;

    /**
     * HttpClientFactory constructor.
     * @param Options $options
     */
    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    /**
     * @return HttpClientInterface
     */
    public function createClient()
    {
        return $this->options->isSimpleClientType()
            ? new SimpleHttpClient()
            : (new ComplexHttpClient($this->options))->getClient();
    }
}