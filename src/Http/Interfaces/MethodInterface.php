<?php

namespace API\Http\Interfaces;

interface MethodInterface
{
    const POST = 'post';
    const GET = 'get';
    const PUT = 'put';
    const PATCH = 'patch';
    const DELETE = 'delete';
    public function setMethod(string $method): MethodInterface;
    public function getMethod(): string;
}
