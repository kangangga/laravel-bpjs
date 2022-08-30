<?php

namespace Kangangga\Bpjs\Api;

use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Traits\Macroable;

abstract class BaseApi
{
    use Macroable;

    public Request $request;

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

    public function response($result): Response
    {
        return new Response($result, $this->request);
    }
}
