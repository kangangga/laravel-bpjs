<?php

namespace Kangangga\Bpjs\Api;

class VClaim extends BaseApi
{
    /**
     * @param  string  $params  Kode atau Nama Diagnosa
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function diagnosa($params)
    {
        return $this->response(
            $this->request->http->get("/referensi/diagnosa/{$params}")
        );
    }
}
