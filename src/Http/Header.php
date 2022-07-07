<?php

namespace API\Http;

use API\Http\Interfaces\HeaderInterface;

class Header implements HeaderInterface
{
    protected array $headers;

    public function withHeader(string $key, string $value): Header
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
