<?php

namespace API\Http;

use API\Http\Interfaces\MethodInterface;

class Method implements MethodInterface
{
    protected string $method;

    public function __construct(string $method)
    {
        $this->method = $method;
        return $this;
    }

    public function setMethod(string $method): MethodInterface
    {
        $this->method = $method;
        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
