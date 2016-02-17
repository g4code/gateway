<?php

namespace G4\Gateway;

class Params
{

    private $value;

    public function __construct(array $value = null)
    {
        $this->value = $value === null ? [] : $value;
    }

    public function __toString()
    {
        return http_build_query($this->value);
    }

    public function toArray()
    {
        return $this->value;
    }
}