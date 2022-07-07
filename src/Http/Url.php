<?php

namespace API\Http;

use API\Http\Interfaces\UrlInterface;

class Url implements UrlInterface
{
    protected string $url = '';
    public function __construct(string $url)
    {
        if(empty($url)) {
            return new \Exception('The URI cannot be empty');
        }
        $this->url = htmlspecialchars(rtrim($url, '/'));
        return $this;
    }

    public function withPath(string $path): Url
    {
        $this->url .=  '/' . ltrim($path, '/');
        return $this;
    }

    public function withEndpoint(string $endpoint): Url
    {
        $this->url .= '/' . ltrim($endpoint, '/');
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
