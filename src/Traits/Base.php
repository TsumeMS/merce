<?php

namespace API\Traits;

use API\Http\Auth;
use API\Http\Body;
use API\Http\Header;
use API\Http\Interfaces\AuthInterface;
use API\Http\Interfaces\BodyInterface;
use API\Http\Interfaces\HeaderInterface;
use API\Http\Interfaces\MethodInterface;
use API\Http\Interfaces\UrlInterface;
use API\Http\Method;
use API\Http\Url;

trait Base
{
    public function makeMethod(string $method): MethodInterface
    {
        return (new Method())->setMethod($method);
    }

    public function makeUrl($url): UrlInterface
    {
        $urlParts = explode('/', $url);
        $urlParam = (new Url($urlParts[0]))->withEndpoint($urlParts[count($urlParts) - 1]);
        unset($urlParts[0]);
        unset($urlParts[count($urlParts) -1 ]);
        $urlParam->withPath(implode('/', $urlParts));
        return $urlParam;
    }

    public function makeHeader(array $headers): HeaderInterface
    {
        $headerParam = new Header();
        foreach ($headers as $key => $value) {
            $headerParam->withHeader($key, $value);
        }
        return $headerParam;
    }

    public function makeBody($body): BodyInterface
    {
        return new Body($body);
    }

    public function makeAuth(string $type, array $credentials): AuthInterface
    {
        $auth = new Auth();
        if($type === AuthInterface::TYPE_BASIC) {
            $auth->withAuthBasic($credentials);
        }
        if($type === AuthInterface::TYPE_JWT) {
            $auth->withAuthJWT($credentials['token']);
        }
        return $auth;
    }
}
