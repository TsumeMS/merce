<?php

namespace API;

use API\Http\Body;
use API\Http\Interfaces\MethodInterface;
use API\Http\Interfaces\RequestInterface;
use API\Http\Interfaces\ResponseInterface;
use API\Http\Interfaces\UrlInterface;
use API\Http\Request;
use API\Http\Response;
use API\Traits\Base;

class Client
{
    use Base;

    protected Request $req;

    public function __construct(string $method = '', string $url = '', array $headers = [], array $body = [])
    {
        $req = new Request();
        if(isset($method)) {
            $req->withMethod($this->makeMethod($method));
        }
        if(isset($url)) {
            $req->withUrl($this->makeUrl($url));
        }
        if(isset($headers)) {
            $req->withHeader($this->makeHeader($headers));
        }
        if(isset($body)) {
            $req->withBody(new Body($body));
        }
        return $this;
    }

    public function call(RequestInterface $request): ResponseInterface
    {
        return new Response($request);
    }

    public function request(string $method, string $url, array $params = []): ResponseInterface
    {
        $this->req->withMethod($this->makeMethod($method))
            ->withUrl($this->makeUrl($url));
        if(isset($params['header'])) {
            $this->req->withHeader($this->makeHeader($params['header']));
        }
        if(isset($params['body'])) {
            $this->req->withBody($this->makeBody($params['body']));
        }
        if(isset($params['auth'])) {
            $this->req->withAuth($this->makeAuth($params['auth']['type'], $params['auth']['credentials']));
        }
        return $this->call($this->req);
    }

    public function get(UrlInterface $url): ResponseInterface
    {
        $this->req->withMethod($this->makeMethod(MethodInterface::GET))->withUrl($url);
        return $this->call($this->req);
    }

    public function post(UrlInterface $url, array $data): ResponseInterface
    {
        $this->req->withMethod($this->makeMethod(MethodInterface::POST))->withBody($this->makeBody($data))->withUrl($url);
        return $this->call($this->req);
    }

    public function patch(UrlInterface $url, array $data): ResponseInterface
    {
        $this->req->withMethod($this->makeMethod(MethodInterface::PATCH))->withBody($this->makeBody($data))->withUrl($url);
        return $this->call($this->req);
    }

    public function put(UrlInterface $url, array $data): ResponseInterface
    {
        $this->req->withMethod($this->makeMethod(MethodInterface::PUT))->withBody($this->makeBody($data))->withUrl($url);
        return $this->call($this->req);
    }

    public function delete(UrlInterface $url, array $data): ResponseInterface
    {
        $this->req->withMethod($this->makeMethod(MethodInterface::DELETE))->withBody($this->makeBody($data))->withUrl($url);
        return $this->call($this->req);
    }
}
