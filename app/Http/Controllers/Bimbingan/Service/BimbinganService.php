<?php

namespace App\Http\Controllers\Bimbingan\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bimbingan\StoreBimbinganRequest;
use App\Http\Requests\Bimbingan\StoreCatatanPembimbingRequest;
use App\Models\Bimbingan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class BimbinganService extends Controller
{
    public function store(StoreBimbinganRequest $request, $id){
        //dd($request->all(), $id);
        $isIdDplNull = $this->isIdDplNull($id);
        if($isIdDplNull){
            return $this->sendResponse(false, 404, false, 'Gagal', 'mahasiswa belum diasosiakan dengan dpl');
        }
        else{
            return $this->storeBimbingan($request->all(), $id);  
        }
    }

    public function storeCatatanPembimbing(StoreCatatanPembimbingRequest $request, $id){
        try {
            Bimbingan::where('id', $id)->update([
                'catatan_pembimbing' => $request->catatan_pembimbing
            ]);
            return $this->sendResponse(null, 200, true, 'berhasil', 'berhasil tambah catatan pembimbing');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 400, false, 'gagal', $e->getMessage());
        }
    }

    public function getBimbinganByIdMahasiswa($id){
        try {
            $bimbingan = Bimbingan::where('id_mahasiswa', $id)->get();
            return $this->sendResponse($bimbingan, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 400, false, 'gagal', $e->getMessage());
        }
    }

    private function storeBimbingan($credential, $id){
        try {
            Bimbingan::where('id', $id)->update([
                'keterangan_bimbingan' => $credential['keterangan_bimbingan'],
                'link' => $credential['link']
            ]);
            return $this->sendResponse(null, 200, true, 'berhasil', 'berhasil tambah bimbingan');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 400, false, 'gagal', $e->getMessage());
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
