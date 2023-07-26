<?php

namespace App\Http\Controllers\Sekolah\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sekolah\StoreSekolahRequest;
use App\Models\Sekolah;

class SekolahService extends Controller
{
    public function getSekolah(){
        try {
            $sekolah = Sekolah::paginate(10);
            return $this->sendResponse($sekolah, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 404, false, 'gagal', $e->getMessage());
        }
    }

    public function store(StoreSekolahRequest $request){
        //dd($request->validated());
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
