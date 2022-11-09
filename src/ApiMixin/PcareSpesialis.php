<?php

namespace Kangangga\Bpjs\ApiMixin;

use Kangangga\Bpjs\Api\BaseApi;

class PcareSpesialis extends BaseApi
{
    /**
     * Fungsi : Get Data spesialis
     *
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function get()
    {
        return $this->response(
            $this->request->get('/spesialis')
        );
    }

    /**
     * Fungsi : Get Data subspesialis
     *
     * @param  string  $kode_spesialis Kode Spesialis
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function subspesialis($kode_spesialis)
    {
        return $this->response(
            $this->request->get("/spesialis/{$kode_spesialis}/subspesialis")
        );
    }

    /**
     * Fungsi : Get Data sarana
     *
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function sarana()
    {
        return $this->response(
            $this->request->get('/spesialis/sarana')
        );
    }
}
