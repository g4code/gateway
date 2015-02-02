<?php

namespace G4\Gateway;

interface GatewayInterface
{
    public function getHttpMethod();

    public function getHttpQueryParams();

    public function getServiceName();
}