<?php

namespace App\Http\Controllers\Akun\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akun\StoreAkunRequest;
use App\Http\Requests\Akun\UpdateAkunRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AkunService extends Controller
{
    public function getAkuns(){
        $akuns = User::latest()->get();
        return $this->responseService($akuns, 200, true, null, null);
    }

    public function store(StoreAkunRequest $request){
        User::create($request->validated());
        return $this->responseService(null, 200, true, 'Berhasil', 'Tambah Akun Berhasil');
    }

    public function update(UpdateAkunRequest $request,$id){
        User::where('id', $id)->update($request->validated());
        return $this->responseService(null, 200, true, 'Berhasil', 'Ubah Data Berhasil');
    }

    public function destroy($id){
        User::destroy($id);
        return $this->responseService(null, 200, true, 'Berhasil', 'hapus akun berhasil');
    }

    public function getAkunById($id){
        $akun = User::find($id);
        return $this->responseService($akun, 200, true, null, null);
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
