<?php

namespace Kangangga\Bpjs\ApiMixin;

use Kangangga\Bpjs\Api\BaseApi;

class PcareKunjungan extends BaseApi
{
    /**
     * Fungsi : Get Data Rujukan
     *
     * @param  string  $no_kunjungan Nomor Kunjungan
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function rujukan($no_kunjungan)
    {
        return $this->response(
            $this->request->get("/kunjungan/rujukan/{$no_kunjungan}")
        );
    }

    /**
     * Fungsi : Get Data Riwayat Kunjungan
     *
     * @param  string  $no_kartu Nomor kartu peserta
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function peserta($no_kartu)
    {
        return $this->response(
            $this->request->get("/kunjungan/peserta/{$no_kartu}")
        );
    }

    /**
     * Fungsi : Delete Data Kunjungan
     *
     * @param  string  $no_kunjungan Nomor Kunjungan
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function deleteKunjungan($no_kunjungan)
    {
        return $this->response(
            $this->request->delete("/kunjungan/{$no_kunjungan}")
        );
    }

    /**
     * Fungsi : Edit Data Kunjungan
     *
     * @param  array  $data
     * @param  string  $type hemodialisa atau spesialis
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function editKunjungan($data, $type = 'hemodialisa')
    {
        if ($type === 'hemodialisa') {
            $data = $this->__validateKunjunganHemodialisa($data);
        } elseif ($type === 'spesialis') {
            $data = $this->__validateKunjunganSpesialis($data);
        }

        return $this->response(
            $this->request
                ->contentType('text/plain')
                ->put('/kunjungan', $data)
        );
    }

    /**
     * Fungsi : Add Data Kunjungan
     *
     * @param  array  $data
     * @param  string  $type hemodialisa atau spesialis
     * @return \Kangangga\Bpjs\Api\Response
     */
    public function addKunjungan($data, $type = 'hemodialisa')
    {
        if ($type === 'hemodialisa') {
            $data = $this->__validateKunjunganHemodialisa($data);
        } elseif ($type === 'spesialis') {
            $data = $this->__validateKunjunganSpesialis($data);
        }

        return $this->response(
            $this->request
                ->contentType('text/plain')
                ->post('/kunjungan', $data)
        );
    }

    private function __validateKunjunganHemodialisa($data)
    {
        return $this->request->validate($data, [
            'noKunjungan' => 'nullable',
            'noKartu' => 'required',
            'tglDaftar' => 'required|date',
            'kdPoli' => 'nullable',
            'keluhan' => 'required',
            'kdSadar' => 'required',
            'sistole' => 'required',
            'diastole' => 'required',
            'beratBadan' => 'required',
            'tinggiBadan' => 'required',
            'respRate' => 'required',
            'heartRate' => 'required',
            'lingkarPerut' => 'required',
            'terapi' => 'required',
            'kdStatusPulang' => 'required',
            'tglPulang' => 'required|date',
            'kdDokter' => 'required',
            'kdDiag1' => 'required',
            'kdDiag2' => 'nullable',
            'kdDiag3' => 'nullable',
            'kdPoliRujukInternal' => 'nullable',
            'rujukLanjut.tglEstRujuk' => 'required|date',
            'rujukLanjut.kdppk' => 'required',
            'rujukLanjut.subSpesialis' => 'nullable',
            'rujukLanjut.khusus.kdKhusus' => 'nullable',
            'rujukLanjut.khusus.kdSubSpesialis' => 'nullable',
            'rujukLanjut.khusus.catatan' => 'nullable',
            'kdTacc' => 'nullable',
            'alasanTacc' => 'nullable',
        ]);
    }

    private function __validateKunjunganSpesialis($data)
    {
        return $this->request->validate($data, [
            'noKunjungan' => 'nullable',
            'noKartu' => 'required',
            'tglDaftar' => 'required|date',
            'kdPoli' => 'required',
            'keluhan' => 'required',
            'kdSadar' => 'required',
            'sistole' => 'required',
            'diastole' => 'required',
            'beratBadan' => 'required',
            'tinggiBadan' => 'required',
            'respRate' => 'required',
            'heartRate' => 'required',
            'lingkarPerut' => 'required',
            'terapi' => 'required',
            'kdStatusPulang' => 'required',
            'tglPulang' => 'required|date',
            'kdDokter' => 'required',
            'kdDiag1' => 'required',
            'kdDiag2' => 'nullable',
            'kdDiag3' => 'nullable',
            'kdPoliRujukInternal' => 'nullable',
            'rujukLanjut.kdppk' => 'required',
            'rujukLanjut.khusus' => 'nullable',
            'rujukLanjut.tglEstRujuk' => 'required|date',
            'rujukLanjut.subSpesialis.kdSarana' => 'nullable',
            'rujukLanjut.subSpesialis.kdSubSpesialis1' => 'required',
            'kdTacc' => 'required',
            'alasanTacc' => 'nullable',
        ]);
    }
}
