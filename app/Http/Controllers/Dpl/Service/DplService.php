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
    public function getDpls(Request $request){
        try {
            $queryDpl = Dpl::latest();
            if($request->filled('nama')){
                $queryDpl->where('nama', 'like', '%'.$request->nama.'%');
            }
            if($request->filled('dkl')){
                $queryDpl->where('dkl', $request->dkl);
            }
            $dpl = $queryDpl->paginate(10);
            return $this->responseService($dpl, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e);
        }
    }

    public function getDplByProdi($prodi){
        try {
            $dpl = Dpl::where('prodi', $prodi)->get();
            return $this->responseService($dpl, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService($dpl, 400, false, 'Gagal', $e);
        }
    }

    public function store(StoreDplRequest $request){
        try {
            $this->storeDpl($request->all());
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
        try {
            Dpl::where('id', $id)->update($request->validated());
            return $this->responseService(null, 200, true, 'Berhasil', 'berhasil ubah data');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e->getMessage());
        }
        
    }

    public function getDplById($id){
        $dpl = Dpl::find($id);
        return $this->responseService($dpl, 200, true, null, null);
    }

    public function getDplGuruPamongById($id){
        $dplGuruPamongById = DB::table('dpl')->join('guru_pamong', 'dpl.id', '=', 'guru_pamong.id_dpl')->select('guru_pamong.id', 'guru_pamong.nama', 'guru_pamong.asal', 'guru_pamong.asal_sekolah', 'guru_pamong.bidang_keahlian')->where('guru_pamong.id_dpl', $id)->get();
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
            $guruPamongs = GuruPamong::whereNull('id_dpl')->get();
            return $this->responseService($guruPamongs, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, null);
        }
    }

    private function storeDpl($request){
        //return $request['dkl']['id'];
        try {
            Dpl::create([
                'dkl' => $request['dkl']['id'],
                'nama' => $request['nama'],
                'nipy' => $request['nipy'],
                'email' => $request['email'],
                'prodi' => $request['prodi']
            ]);
            return true;
        } catch (\Illuminate\Database\QueryException $e) {
            return $e->getMessage();            
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
