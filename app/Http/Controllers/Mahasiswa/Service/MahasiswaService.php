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

    public function getMahasiswaById($id){
        $mahasiswa = Mahasiswa::find($id);
        return $this->responseService($mahasiswa, 200, true, null, null);
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

    public function getMahasiswaGuruPamongById($id){
        try {
            $mahasiswa = DB::table('guru_pamong')->join('mahasiswa', 'guru_pamong.id', '=', 'mahasiswa.id_guru_pamong')->select(
                'mahasiswa.id',
                'mahasiswa.nama',
                'mahasiswa.nim',
                'mahasiswa.prodi',
                'mahasiswa.email',
                'guru_pamong.nama AS nama_guru_pamong',
                'mahasiswa.n_komponen_satu',
                'mahasiswa.n_komponen_dua',
                'mahasiswa.n_komponen_tiga',
                'mahasiswa.n_komponen_empat',
                'mahasiswa.nilai'
                )->where('mahasiswa.id', $id)->first();
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e);
        }
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
        $nilai = ($credential['n_komponen_satu'] + $credential['n_komponen_dua'] + $credential['n_komponen_tiga'] + $credential['n_komponen_empat']) / 4;
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
