<?php

namespace G4\Gateway;

use \G4\Constants\Http;

abstract class GatewayHttpPostAbstract extends GatewayAbstract
{

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return Http::METHOD_POST;
    }
}