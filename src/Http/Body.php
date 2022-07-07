<?php

namespace API\Http;

use API\Http\Interfaces\BodyInterface;

class Body implements BodyInterface
{
    protected array $body;

    public function __construct(array $body)
    {
        $this->body = $body;
        return $this;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}
