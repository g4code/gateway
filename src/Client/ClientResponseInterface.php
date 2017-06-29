<?php

namespace G4\Gateway\Client;

interface ClientResponseInterface
{
    public function getBody();
    public function getCode();
    public function getHeaders();
    public function getIdentifier();
    public function getParams();
    public function getResource($key);
    public function isClientError();
    public function isServerError();
    public function isSuccess();
}