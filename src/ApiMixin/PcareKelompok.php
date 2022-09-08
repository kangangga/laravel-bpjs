<?php

namespace Kangangga\Bpjs\ApiMixin;

use Kangangga\Bpjs\Api\BaseApi;

class PcareKelompok extends BaseApi
{
    /**
     * Fungsi : Get Data Club Prolanis
     *
     * @param string $search Kode Jenis Kelompok => 01 : Diabetes Melitus, 02 : Hipertensi
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function club($search)
    {
        return $this->response(
            $this->request->get("/kelompok/club/{$search}")
        );
    }

    /**
     * Fungsi : Get Data Kegiatan Kelompok
     *
     * @param string|\Illuminate\Support\Carbon $date Bulan, format => dd-mm-yyyy
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function kegiatan($date)
    {
        if ($date instanceof \Illuminate\Support\Carbon) {
            $date = $date->format('d-m-Y');
        }

        return $this->response(
            $this->request->get("/kelompok/kegiatan/{$date}")
        );
    }

    /**
     * Fungsi : Get Data Peserta Kegiatan Kelompok
     *
     * @param string $edu_id eduId
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function peserta($edu_id)
    {
        return $this->response(
            $this->request->get("/kelompok/peserta/{$edu_id}")
        );
    }

    /**
     * Fungsi : Add Data Kegiatan Kelompok
     *
     * @param array[clubId,tglPelayanan,kdKegiatan,kdKelompok,materi,pembicara,lokasi,keterangan,biaya] $data
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function addKegiatan($data)
    {
        $valid = $this->request->validate($data, [
            'clubId' => 'required',
            'tglPelayanan' => 'required|date',
            'kdKegiatan' => 'required',
            'kdKelompok' => 'required',
            'materi' => 'required',
            'pembicara' => 'required',
            'lokasi' => 'required',
            'keterangan' => 'required',
            'biaya' => 'required',
        ]);

        return $this->response(
            $this->request
                ->contentType('text/plain')
                ->post("/kelompok/kegiatan", $valid)
        );
    }

    /**
     * Fungsi : Add Data Peserta Kegiatan Kelompok
     *
     * @param array[clubId,noKartu] $data
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function addPeserta($data)
    {
        $valid = $this->request->validate($data, [
            'eduId' => 'required',
            'noKartu' => 'required|min:8|max:20',
        ]);

        return $this->response(
            $this->request
                ->contentType('text/plain')
                ->post("/kelompok/peserta", $valid)
        );
    }

    /**
     * Fungsi : Delete Data Kegiatan Kelompok
     *
     * @param string $edu_id eduId
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function deleteKegiatan($edu_id)
    {
        return $this->response(
            $this->request->delete("/kelompok/kegiatan/{$edu_id}")
        );
    }

    /**
     * Fungsi : Delete Data Peserta Kegiatan Kelompok
     *
     * @param string $edu_id eduId
     * @param string $no_kartu Nomor Kartu Peserta
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function deletePeserta($edu_id, $no_kartu)
    {
        return $this->response(
            $this->request->delete("/kelompok/peserta/{$edu_id}/{$no_kartu}")
        );
    }
}
