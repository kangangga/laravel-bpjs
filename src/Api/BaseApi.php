<?php

namespace Kangangga\Bpjs\Api;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Traits\Macroable;

abstract class BaseApi
{
    use Macroable;

    public $extends;

    /** @var Request|PendingRequest */
    public Request $request;


    public PendingRequest $http;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function boot($config)
    {
    }

    public function beforeSending(ClientRequest $clientRequest)
    {
    }

    public function response($result, $validator = null): Response
    {
        return new Response($result, $this->request, $validator);
    }

    public function extends()
    {
        return $this->extends;
    }
}
