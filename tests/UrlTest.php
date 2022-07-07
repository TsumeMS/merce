<?php

namespace Tests;

use API\Http\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function testReturnExceptionWhenEmptyUrl()
    {
        try {
            $url = new Url('');
        } catch (\Exception $ex) {
            $this->assertStringContainsString('The URI cannot be empty', $ex->getMessage());
        }
    }

    public function testReturnUrlWithPathAsString()
    {
        $url = (new Url('localhost:8080'))->withPath('api/v1/call');
        $this->assertIsString($url->getUrl());
    }
}
