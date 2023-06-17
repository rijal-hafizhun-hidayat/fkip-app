<?php

namespace App\Http\Controllers\Mahasiswa\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mahasiswa\StoreMahasiswaRequest;
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
