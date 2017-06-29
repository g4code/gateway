<?php

namespace G4\Gateway\Client;

use G4\Gateway\Url;
use G4\Gateway\HttpMethod;

interface HttpClientInterface
{
    public function send(Url $url, HttpMethod $method);
}