<?php

namespace App\Http\Controllers\Dpl\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dpl\StoreDplRequest;
use App\Http\Requests\Dpl\UpdateDplRequest;
use App\Models\Dpl;
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
