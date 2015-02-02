<?php

namespace G4\Gateway;

use \G4\Constants\Http;

abstract class GatewayHttpGetAbstract extends GatewayAbstract
{

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return Http::METHOD_GET;
    }
}