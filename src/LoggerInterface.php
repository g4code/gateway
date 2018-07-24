<?php

namespace G4\Gateway;

interface LoggerInterface
{
    public function log(FullRequestInfo $response, $tagName);
}
