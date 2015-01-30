<?php

namespace G4\Gateway;

use \G4\Constants\Http;

abstract class GatewayHttpDeleteAbstract extends GatewayAbstract
{

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return Http::METHOD_PUT;
    }
}