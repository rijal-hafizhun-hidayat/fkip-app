<?php

namespace App\Http\Controllers\Mahasiswa\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mahasiswa\StoreMahasiswaRequest;
use App\Http\Requests\Mahasiswa\UpdateMahasiswaRequest;
use App\Http\Requests\Mahasiswa\UpdateNilaiMahasiswa;
use Illuminate\Support\Facades\DB;
use App\Models\GuruPamong;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaService extends Controller
{
    public function getMahasiswa(){
        $mahasiswa = Mahasiswa::latest()->get();
        return $this->responseService($mahasiswa, 200, true, null, null);
    }

    public function getMahasiswaByIdAkun($id){
        try {
            $mahasiswa = Mahasiswa::where('id_guru_pamong', $id)->get();
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, null);
        }
    }

    public function getMahasiswaById($id){
        try {
            $mahasiswa = Mahasiswa::find($id);
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e);
        }
    }

    public function store(StoreMahasiswaRequest $request){
        Mahasiswa::create($request->validated());
        return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Tambah Mahasiswa');
    }

    public function update(UpdateMahasiswaRequest $request, $id){
        Mahasiswa::where('id', $id)->update($request->validated());
        return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Ubah Mahasiswa');
    }

    public function destroy($id){
        Mahasiswa::destroy($id);
        return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Hapus Mahasiswa');
    }

    public function updateNilai(UpdateNilaiMahasiswa $request, $id){
        $data = $this->setNilai($request->validated());
        try {
            Mahasiswa::where('id', $id)->update($data);
            return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Update Nilai');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e);
        }
    }

    private function setNilai($credential){
        $nilai = ($credential['n_komponen_satu'] + $credential['n_komponen_dua'] + $credential['n_komponen_tiga'] + $credential['n_komponen_empat'] + $credential['n_komponen_lima']) / 5;
        $credential['nilai'] = $nilai;

        return $credential;
    }

    private function responseService($data, $code, $status, $title, $text){
        $response = [
            'data' => $data,
            'code' => $code,
            'status' => $status,
            'title' => $title,
            'text' => $text
        ];

        return response()->json($response, $code);
    }
}
