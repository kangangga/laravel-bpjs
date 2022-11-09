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

    /**
     * @var \Kangangga\Bpjs\ApiMixin\PcareSpesialis
     * @see https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/main.html#/mitra/katalog/pcare/spesialis
     */
    public \Kangangga\Bpjs\ApiMixin\PcareSpesialis $spesialis;

    public $extends = [
        'mcu' => \Kangangga\Bpjs\ApiMixin\PcareMCU::class,
        'kelompok' => \Kangangga\Bpjs\ApiMixin\PcareKelompok::class,
        'kunjungan' => \Kangangga\Bpjs\ApiMixin\PcareKunjungan::class,
        'spesialis' => \Kangangga\Bpjs\ApiMixin\PcareSpesialis::class,
    ];

    /**
     * Fungsi : Get Data Diagnosa
     *
     * @param  string  $search Kode atau nama diagnosa
     * @param  int  $offset Row data awal yang akan ditampilkan
     * @param  int  $limit Limit jumlah data yang akan ditampilkan
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function diagnosa($search, $offset = 1, $limit = 100)
    {
        return $this->response(
            $this->request->http->get("/diagnosa/{$search}/{$offset}/{$limit}")
        );
    }

    /**
     * Fungsi : Get Data Dokter
     *
     * @param  int  $offset Row data awal yang akan ditampilkan
     * @param  int  $limit Limit jumlah data yang akan ditampilkan
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function dokter($offset = 1, $limit = 100)
    {
        return $this->response(
            $this->request->http->get("/dokter/{$offset}/{$limit}")
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

    /**
     * Fungsi : Get Data poli
     * @param  int  $limit Limit jumlah data yang akan ditampilkan
     * @param  int  $offset Row data awal yang akan ditampilkan
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function poli($limit = 100, $offset = 0)
    {
        return $this->response(
            $this->request->http->get("/poli/fktp/{$offset}/{$limit}")
        );
    }

    /**
     * Fungsi : Get Data provider
     * @param  int  $limit Limit jumlah data yang akan ditampilkan
     * @param  int  $offset Row data awal yang akan ditampilkan
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function provider($limit = 100, $offset = 0)
    {
        return $this->response(
            $this->request->http->get("/provider/{$offset}/{$limit}")
        );
    }
}
