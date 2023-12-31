<?php

namespace App\Http\Controllers\Bimbingan\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bimbingan\StoreBimbinganRequest;
use App\Http\Requests\Bimbingan\StoreCatatanPembimbingRequest;
use App\Http\Requests\Bimbingan\UpdateBimbinganRequest;
use App\Models\Bimbingan;
use App\Models\GuruPamong;
use App\Models\Mahasiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BimbinganService extends Controller
{
    public function store(StoreBimbinganRequest $request, $id){
        $isIdDplValue = $this->isIdDplNull($id);
        if($isIdDplValue == null){
            return $this->sendResponse(false, 404, false, 'Gagal', 'mahasiswa belum diasosiakan dengan dpl');
        }
        else{
            return $this->storeBimbingan($request->all(), $id, $isIdDplValue);  
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

    public function destroy($id){
        try {
            Bimbingan::destroy($id);
            return $this->sendResponse(null, 200, true, 'berhasil', 'berhasil hapus data');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 200, false, 'gagal', $e->getMessage());
        }
    }

    public function getBimbinganById($id){
        try {
            $bimbingan = Bimbingan::find($id);
            return $this->sendResponse($bimbingan, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 400, false, null, $e->getMessage());
        }
    }

    public function update(UpdateBimbinganRequest $request, $id){
        try {
            Bimbingan::where('id', $id)->update([
                'link' => $request->link,
                'catatan_pembimbing' => $request->catatan_pembimbing,
                'tahap_bimbingan' => $request->tahap_bimbingan,
                'keterangan_bimbingan' => $request->keterangan_bimbingan,
                'updated_at' => Carbon::now()
            ]);
            return $this->sendResponse(null, 200, true, 'berhasil', 'berhasil update bimbingan');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 400, false, null, $e->getMessage());
        }
    }

    public function confirmed(Request $request, $id){
        try {
            $bimbingan = Bimbingan::find($id);
            $bimbingan->confirmed = $request->confirmed;
            $bimbingan->save();

            return $this->sendResponse(null, 200, true, 'berhasil', 'berhasil Konfirmasi status bimbingan');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 400, false, null, $e->getMessage());
        }
    }

    public function printPdf($id){
        dd($id);
    }

    private function storeBimbingan($credential, $id, $idDpl){
        try {
            Bimbingan::create([
                'id_mahasiswa' => $id,
                'id_dpl' => $idDpl,
                'keterangan_bimbingan' => $credential['keterangan_bimbingan'],
                'tahap_bimbingan' => $credential['tahap_bimbingan'],
                'link' => $credential['link'],
                'confirmed' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            return $this->sendResponse(null, 200, true, 'berhasil', 'berhasil tambah bimbingan');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 400, false, 'gagal', $e->getMessage());
        }
    }

    private function isIdDplNull($id){
        $Mahasiswa = Mahasiswa::find($id);
        $GuruPamong = GuruPamong::find($Mahasiswa->id_guru_pamong);
        if($GuruPamong){
            return $GuruPamong->id_dpl;
        }
        else{
            return null;
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
