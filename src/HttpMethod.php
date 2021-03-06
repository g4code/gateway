<?php

namespace G4\Gateway;

class HttpMethod
{

    const GET    = 'GET';
    const PATCH  = 'PATCH';
    const POST   = 'POST';
    const PUT    = 'PUT';
    const DELETE = 'DELETE';

    /**
     * @var string
     */
    private $value;

    /**
     * @param $value
     */
    public function __construct($value)
    {
        if (!$this->isValid($value)) {
            throw new \Exception('Http method is not valid', 101);
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return in_array($this->value, [
            self::POST,
            self::PUT,
        ]);
    }

    /**
     * @return bool
     */
    public function isGet()
    {
        return $this->value === self::GET;
    }

    /**
     * @param $value
     * @return bool
     */
    private function isValid($value)
    {
        return in_array($value, [
            self::DELETE,
            self::GET,
            self::PATCH,
            self::POST,
            self::PUT,
        ]);
    }
}
