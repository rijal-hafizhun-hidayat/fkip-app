<?php

namespace App\Http\Controllers\Guru_Pamong\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guru_Pamong\StoreGuruPamongRequest;
use App\Http\Requests\Guru_Pamong\UpdateGuruPamongRequest;
use App\Models\GuruPamong;
use Illuminate\Http\Request;

class GuruPamongService extends Controller
{
    public function getGuruPamongs(){
        $data = GuruPamong::latest()->get();
        return $this->responseService($data, 200, true, null, null);
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
