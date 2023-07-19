<?php

namespace App\Http\Controllers\Bimbingan\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bimbingan\StoreBimbinganRequest;
use App\Models\Bimbingan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class BimbinganService extends Controller
{
    public function store(StoreBimbinganRequest $request, $id){
        $isIdDplNull = $this->isIdDplNull($id);
        if($isIdDplNull){
            return $this->sendResponse(false, 404, false, 'Gagal', 'mahasiswa belum diasosiakan dengan dpl');
        }
        else{
            dd(false);
        }
    }

    private function isIdDplNull($id){
        $mahasiswa = Mahasiswa::find($id);
        return is_null($mahasiswa->id_dpl);
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
