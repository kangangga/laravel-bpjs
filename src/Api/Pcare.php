<?php

namespace Kangangga\Bpjs\Api;

class Pcare extends BaseApi
{
    /**
     * @var \Kangangga\Bpjs\ApiMixin\PcareMCU
     * @see https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/pcare/mcu
     */
    public \Kangangga\Bpjs\ApiMixin\PcareMCU $mcu;

    /**
     * @var \Kangangga\Bpjs\ApiMixin\PcareKelompok
     * @see https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/pcare/kelompok
     */
    public \Kangangga\Bpjs\ApiMixin\PcareKelompok $kelompok;

    /**
     * @var \Kangangga\Bpjs\ApiMixin\PcareKunjungan
     * @see https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/pcare/kunjungan
     */
    public \Kangangga\Bpjs\ApiMixin\PcareKunjungan $kunjungan;

    public $extends = [
        'mcu' => \Kangangga\Bpjs\ApiMixin\PcareMCU::class,
        'kelompok' => \Kangangga\Bpjs\ApiMixin\PcareKelompok::class,
        'kunjungan' => \Kangangga\Bpjs\ApiMixin\PcareKunjungan::class
    ];

    /**
     * Fungsi : Get Data Diagnosa
     *
     * @param string $search Kode atau nama diagnosa
     * @param integer $page Row data awal yang akan ditampilkan
     * @param integer $limit Limit jumlah data yang akan ditampilkan
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function diagnosa($search, $page = 1, $limit = 100)
    {
        return $this->response(
            $this->request->http->get("/diagnosa/{$search}/{$page}/{$limit}")
        );
    }

    /**
     * Fungsi : Get Data Dokter
     *
     * @param integer $page Row data awal yang akan ditampilkan
     * @param integer $limit Limit jumlah data yang akan ditampilkan
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function dokter($page = 1, $limit = 100)
    {
        return $this->response(
            $this->request->http->get("/dokter/{$page}/{$limit}")
        );
    }

    /**
     * Fungsi : Get Data Kesadaran
     *
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function kesadaran()
    {
        return $this->response(
            $this->request->http->get('/kesadaran')
        );
    }
}
