<?php

namespace API\Http;

use API\Http\Interfaces\AuthInterface;
use API\Http\Interfaces\BodyInterface;
use API\Http\Interfaces\HeaderInterface;
use API\Http\Interfaces\MethodInterface;
use API\Http\Interfaces\RequestInterface;
use API\Http\Interfaces\ResponseInterface;
use API\Http\Interfaces\UrlInterface;
use API\Traits\Base;

class Response implements ResponseInterface
{
    use Base;

    protected object $curl;
    protected object $result;
    protected array $curlOptions = [
        CURLOPT_RETURNTRANSFER => true,
        CURLINFO_HEADER_OUT => true,
    ];
    protected array $defaultHeaders = [
        'Content-Type' => 'application/json'
    ];

    public function __construct(RequestInterface $request)
    {
        $this->curl = curl_init();
        $this->init($request);
        curl_exec($this->curl);
        return $this;
    }

    public function __destruct()
    {
        if($this->curl) {
            curl_close($this->curl);
        }
    }

    public function getBody(): BodyInterface
    {
        return $this->makeBody($this->curl->getBody());
    }

    public function getHeaders(): HeaderInterface
    {
        return $this->makeHeader($this->curl->getHeaders());
    }

    public function getErrorCode(): int
    {
        return curl_errno($this->curl);
    }

    public function getErrorMessage(): string
    {
        return curl_error($this->curl);
    }

    public function getHttpCode(): int
    {
        return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
    }

    protected function init(RequestInterface $request): void
    {
        foreach ($request->getAttributes() as $attrName => $value) {
            call_user_func([$this, $attrName . 'Set'], $value);
        }
        curl_setopt_array($this->curl, $this->curlOptions);
    }

    protected function urlSet(UrlInterface $url): void
    {
        $this->curlOptions[CURLOPT_URL] = $url->getUrl();
    }

    protected function methodSet(MethodInterface $method): void
    {
        if($method->getMethod() === MethodInterface::POST) {
            $this->curlOptions[CURLOPT_POST] = 1;
        }
        if($method->getMethod() === MethodInterface::PUT
            || $method->getMethod() === MethodInterface::PATCH
            || $method->getMethod() === MethodInterface::DELETE)
        {
            $this->curlOptions[CURLOPT_CUSTOMREQUEST] = $method->getMethod();
        }
    }

    protected function headerSet(HeaderInterface $headers): void
    {
        $this->curlOptions[CURLOPT_HTTPHEADER] = $headers->getHeaders();
    }

    protected function bodySet(BodyInterface $body): void
    {
        $this->curlOptions[CURLOPT_POSTFIELDS] = http_build_query($body->getBody());
    }

    protected function authSet(AuthInterface $auth): void
    {
        if($auth->getType === AuthInterface::TYPE_BASIC) {
            $this->curlOptions[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
            $this->curlOptions[CURLOPT_USERPWD] = $auth->getBasicCredentials();
        }
        if($auth->getType === AuthInterface::TYPE_JWT) {
            $this->curlOptions[CURLOPT_USERPWD] = $auth->getJWTToken();
        }
    }
}
