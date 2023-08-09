<?php

namespace App\Http\Controllers\Sekolah\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sekolah\StoreSekolahRequest;
use App\Http\Requests\Sekolah\UpdateSekolahRequest;
use App\Models\Sekolah;

class SekolahService extends Controller
{
    public function getSekolah(){
        try {
            $querySekolah = $this->setQuerytGetSekolah();
            $sekolah = $querySekolah->paginate(10);
            return $this->sendResponse($sekolah, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 404, false, 'gagal', $e->getMessage());
        }
    }

    public function store(StoreSekolahRequest $request){
        try {
            Sekolah::create($request->validated());
            return $this->sendResponse(null, 200, true, 'berhasil', 'berhasil tambah sekolah');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 404, false, 'gagal', $e->getMessage());
        }
    }

    public function getSekolahById($id){
        try {
            $sekolah = Sekolah::find($id);
            return $this->sendResponse($sekolah, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 404, false, 'gagal', $e->getMessage());
        }
    }

    public function update(UpdateSekolahRequest $request, $id){
        try {
            Sekolah::where('id', $id)->update($request->validated());
            return $this->sendResponse(null, 200, true, 'berhasil', 'berhasil update data');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 404, false, 'gagal', $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            Sekolah::destroy($id);
            return $this->sendResponse(null, 200, true, 'berhasil', 'berhasil hapus data');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 404, false, 'gagal', $e->getMessage());
        }
    }

    private function setQuerytGetSekolah(){
        $dBSekolah = Sekolah::latest();
        if(request()->filled('nama')){
            $dBSekolah->where('nama', 'like', '%'.request()->nama.'%');
        }
        if(request()->filled('jenis_plp')){
            $dBSekolah->where('jenis_plp', request()->jenis_plp);
        }
        return $dBSekolah;
    }

    private function sendResponse($data, $code, $status, $title, $text){
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
