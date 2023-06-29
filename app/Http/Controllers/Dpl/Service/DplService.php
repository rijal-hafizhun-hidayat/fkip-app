<?php

namespace App\Http\Controllers\Dpl\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dpl\StoreDplRequest;
use App\Http\Requests\Dpl\UpdateDplRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Dpl;
use App\Models\GuruPamong;
use Illuminate\Http\Request;

class DplService extends Controller
{
    public function getDpls(){
        $dpls = Dpl::latest()->get();
        return $this->responseService($dpls, 200, true, null, null);
    }

    public function store(StoreDplRequest $request){
        try {
            Dpl::create($request->validated());
            return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Tambah Data');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', 'Nidn / Niy sudah digunakan');
        }
    }

    public function destroy($id){
        Dpl::destroy($id);
        return $this->responseService(null, 200, true, 'Berhasil', 'berhasil hapus data');
    }

    public function update(UpdateDplRequest $request, $id){
        Dpl::where('id', $id)->update($request->validated());
        return $this->responseService(null, 200, true, 'Berhasil', 'berhasil ubah data');
    }

    public function getDplById($id){
        $dpl = Dpl::find($id);
        return $this->responseService($dpl, 200, true, null, null);
    }

    public function getDplGuruPamongById($id){
        $dplGuruPamongById = DB::table('dpl')->join('guru_pamong', 'dpl.id', '=', 'guru_pamong.id_dpl')->select('guru_pamong.id', 'guru_pamong.nama', 'guru_pamong.asal', 'guru_pamong.asal_sekolah')->where('guru_pamong.id_dpl', $id)->get();
        return $this->responseService($dplGuruPamongById, 200, true, null, null);
    }

    public function storeGuruPamong(Request $request, $id){
        try {
            GuruPamong::where('id', $request->id_guru_pamong)->update(['id_dpl' => $id]);
            return $this->responseService(null, 200, true, 'Berhasil', 'berhasil tambah bimbingan dpl guru pamong');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService($e, 400, false, 'Gagal', 'gagal tambah bimbingan dpl guru pamong');
        }
    }

    public function destroyAssociationGuruPamong($id){
        try {
            GuruPamong::where('id', $id)->update(['id_dpl' => null]);
            return $this->responseService(null, 200, true, 'Berhasil', 'berhasil hapus asosiasi guru pamong');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', 'gagal hapus asosiasi guru pamong');
        }
    }

    public function getGuruPamongsIsNull(){
        try {
            GuruPamong::whereNull('id_dpl')->get();
            return $this->responseService(null, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, null);
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