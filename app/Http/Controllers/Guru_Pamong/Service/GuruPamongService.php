<?php

namespace App\Http\Controllers\Guru_Pamong\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guru_Pamong\StoreGuruPamongRequest;
use App\Http\Requests\Guru_Pamong\UpdateGuruPamongRequest;
use App\Models\GuruPamong;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class GuruPamongService extends Controller
{
    public function getGuruPamongs(){
        $data = GuruPamong::latest()->get();
        return $this->responseService($data, 200, true, null, null);
    }

    public function getGuruPamongByIdDpl($id){
        try {
            $guruPamongs = GuruPamong::where('id_dpl', $id)->get();
            return $this->responseService($guruPamongs, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e);
        }
    }

    public function store(StoreGuruPamongRequest $request){
        GuruPamong::create($request->validated());
        return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil tambah data');
    }

    public function getGuruPamongById($id){
        $data = GuruPamong::find($id);
        return $this->responseService($data, 200, true, null, null);
    }

    public function update(UpdateGuruPamongRequest $request, $id){
        GuruPamong::where('id', $id)->update($request->validated());
        return $this->responseService(null, 200, true, 'Berhasil', 'Berhasul Ubah Data');
    }

    public function destroy($id){
        GuruPamong::destroy($id);
        return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Hapus Data');
    }

    public function getMahasiswaByIdGuruPamong($id){
        try {
            $mahasiswa = Mahasiswa::where('id_guru_pamong', $id)->get();
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, null);
        }
    }

    public function storeAsosiasiMahasiswa(Request $request, $id){
        try {
            Mahasiswa::where('id', $request->id_mahasiswa)->update(['id_guru_pamong' => $id]);
            return $this->responseService(null, 200, true, 'Berhasil', 'berhasil tambah asosiasi mahasiswa');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', 'gagal tambah asosiasi mahasiswa');
        }
    }

    public function getMahasiswaIsNull(){
        try {
            $mahasiswaIsNull = Mahasiswa::whereNull('id_guru_pamong')->get();
            return $this->responseService($mahasiswaIsNull, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e);
        }
    }

    public function destroyAsosiasiMahasiswa($id){
        try {
            Mahasiswa::where('id', $id)->update(['id_guru_pamong' => null]);
            return $this->responseService(null, 200, true, 'Berhasil', 'berhasil hapus asosiasi mahasiswa');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', 'gagal hapus asosiasi mahasiswa');
        }
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
