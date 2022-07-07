<?php

namespace Tests;

use API\Client;
use API\Http\Auth;
use API\Http\Body;
use API\Http\Method;
use API\Http\Request;
use API\Http\Response;
use API\Http\Url;
use PHPUnit\Framework\TestCase;

class clientTest extends TestCase
{
    public function testClientCallApiAndGetResponseObject()
    {
        $client = new Client();
        $request = (new Request())->withMethod(new Method('get'))
                                  ->withUrl(new Url('localhost:8080/api/getTest'));
        $response = $client->call($request);
        $this->assertTrue(gettype($response) === Response::class);
    }

    public function testClientResponseBodyInstanceOnPostRequest()
    {
        $client = new Client();
        $auth = new Auth();
        $request = (new Request())->withMethod(new Method('post'))
                                  ->withUrl(new Url('localhost:8080/api/postTest'))
                                  ->withBody(new Body(['tets'=>'test']))
                                  ->withAuth($auth->withAuthBasic(['user'=>'test', 'password'=>'P@ssw0rd']));
        $response = $client->call($request);
        $this->assertInstanceOf(Body::class, $response->getBody());
    }
}
