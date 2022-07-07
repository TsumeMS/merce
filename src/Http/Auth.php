<?php

namespace API\Http;

use API\Http\Interfaces\AuthInterface;

class Auth implements AuthInterface
{
    protected array $credentials = [
        AuthInterface::TYPE_BASIC => [],
        AuthInterface::TYPE_JWT => ''
    ];

    public function withAuthBasic(array $credentials): AuthInterface
    {
        $this->$credentials[AuthInterface::TYPE_BASIC] = $credentials;
        return $this;
    }

    public function withAuthJWT(string $token): AuthInterface
    {
        $this->credentials[AuthInterface::TYPE_JWT] = $token;
        return $this;
    }

    public function getType(): string
    {
        $type = '';
        if(!empty($this->credentials[AuthInterface::TYPE_BASIC])) {
            $type = AuthInterface::TYPE_BASIC;
        } else if(!empty($this->credentials[AuthInterface::TYPE_JWT])) {
            $type = AuthInterface::TYPE_JWT;
        }
        return $type;
    }

    public function getBasicCredentials(): string
    {
        return $this->credentials[AuthInterface::TYPE_BASIC]['user'] . ':' . $this->credentials[AuthInterface::TYPE_BASIC]['password'];
    }

    public function getJWTToken(): string
    {
        return $this->credentials[AuthInterface::TYPE_JWT];
    }
}
