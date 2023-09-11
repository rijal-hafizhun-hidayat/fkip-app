<?php

namespace App\Http\Controllers\Dpl\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dpl\StoreDplRequest;
use App\Http\Requests\Dpl\UpdateDplRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Dpl;
use App\Models\GuruPamong;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DplService extends Controller
{
    public function getDpls(){
        try {
            $queryDpl = $this->setQueryGetDpl();
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
        $dplGuruPamongById = DB::table('dpl')->join('guru_pamong', 'dpl.id', '=', 'guru_pamong.id_dpl')->select('guru_pamong.id', 'guru_pamong.nama', 'guru_pamong.asal_sekolah', 'guru_pamong.bidang_keahlian')->where('guru_pamong.id_dpl', $id)->get();
        return $this->responseService($dplGuruPamongById, 200, true, null, null);
    }

    public function storeGuruPamong(Request $request, $id){
        try {
            if($request->filled('id_guru_pamong')){
                GuruPamong::where('id', $request->id_guru_pamong)->update(['id_dpl' => $id]);
            }
            if($request->filled('id_mahasiswa')){
                Mahasiswa::where('id', $request->id_mahasiswa)->update(['id_dpl' => $id]);
            }
            return $this->responseService(null, 200, true, 'Berhasil', 'berhasil tambah asosiasi');
           
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
            $guruPamongs = GuruPamong::all();
            return $this->responseService($guruPamongs, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, null);
        }
    }

    public function getDplByIdMahasiswa($id){
        try {
            $mahasiswa = Mahasiswa::find($id);
            $guruPamong = GuruPamong::find($mahasiswa->id_guru_pamong);
            $dpl = Dpl::find($guruPamong->id_dpl);
            
            return $this->responseService($dpl, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, null);
        }
    }

    private function setQueryGetDpl(){
        $dBDpls = Dpl::latest();

        if(request()->filled('nama')){
            $dBDpls->where('nama', 'like', '%'.request()->nama.'%');
        }
        if(request()->filled('prodi')){
            $dBDpls->where('prodi', request()->prodi);
        }
        if(request()->filled('jenis_plp')){
            $dBDpls->where('jenis_plp', request()->jenis_plp);
        }

        return $dBDpls;
    }

    private function storeDpl($request){
        try {
            return Dpl::create([
                'nama' => $request['nama'],
                'nipy' => $request['nipy'],
                'prodi' => $request['prodi']
            ]);
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
