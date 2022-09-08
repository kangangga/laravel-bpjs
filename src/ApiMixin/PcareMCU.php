<?php

namespace Kangangga\Bpjs\ApiMixin;

use Kangangga\Bpjs\Api\BaseApi;

class PcareMCU extends BaseApi
{
    /**
     * Fungsi : Get Data kunjungan MCU
     *
     * @param  string  $no_kunjungan Nomor Kunjungan
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function kunjungan($no_kunjungan)
    {
        return $this->response(
            $this->request->get("/mcu/kunjungan/{$no_kunjungan}")
        );
    }
}
