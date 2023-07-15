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
    public function getMahasiswa(Request $request){
        try {
            $queryMahasiswa = Mahasiswa::latest();
            if($request->filled('nama')){
                $queryMahasiswa->where('nama', 'like', '%'.$request->nama.'%');
            }
            $mahasiswa = $queryMahasiswa->paginate(10);
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e);
        }
    }

    public function getMahasiswaByIdAkun(Request $request, $id){
        try {
            $queryMahasiswa = Mahasiswa::latest()->where('id_guru_pamong', $id);
            if($request->filled('nama')){
                $queryMahasiswa->where('nama', 'like', '%'.$request->nama.'%');
            }
            $mahasiswa = $queryMahasiswa->paginate(1);
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e);
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
        //dd(, $id);
        $data = $this->setNilai($request->all());
        try {
            Mahasiswa::where('id', $id)->update($data);
            return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Update Nilai');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e);
        }
    }

    private function setNilai($credential){
        //dd(count($credential['nilai_kompeten']));
        $totalPoint = null;
        for ($i=0; $i <count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }
        //dd($totalPoint);
        $credential['nilai'] = $totalPoint / 5;
        dd($credential);
        // $nilai = ($credential['n_komponen_satu'] + $credential['n_komponen_dua'] + $credential['n_komponen_tiga'] + $credential['n_komponen_empat'] + $credential['n_komponen_lima']) / 5;
        // $credential['nilai'] = $nilai;
        //dd($credential);
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
