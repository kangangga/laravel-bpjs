<?php

namespace Kangangga\Bpjs\Api;

class Pcare extends BaseApi
{
    public function kesadaran()
    {
        return $this->response(
            $this->request->http->get('/kesadaran')
        );
    }
}
