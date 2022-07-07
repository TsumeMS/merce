<?php

namespace API\Http;

use API\Http\Interfaces\AuthInterface;
use API\Http\Interfaces\BodyInterface;
use API\Http\Interfaces\HeaderInterface;
use API\Http\Interfaces\MethodInterface;
use API\Http\Interfaces\RequestInterface;
use API\Http\Interfaces\UrlInterface;

class Request implements RequestInterface
{
    protected array $attributes;

    public function withMethod(MethodInterface $method): Request
    {
        $this->setWitch('method', $method);
        return $this;
    }

    public function withUrl(UrlInterface $url): Request
    {
        $this->setWitch('url', $url);
        return $this;
    }

    public function withHeader(HeaderInterface $header): Request
    {
        $this->setWitch('header', $header);
        return $this;
    }

    public function withBody(BodyInterface $body): Request
    {
        $this->setWitch('body', $body);
        return $this;
    }

    public function withAuth(AuthInterface $auth): Request
    {
        $this->setWitch('auth', $auth);
        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    protected function setWitch(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }
}
