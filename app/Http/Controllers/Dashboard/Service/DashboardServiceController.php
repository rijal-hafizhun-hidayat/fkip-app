<?php

namespace App\Http\Controllers\Dashboard\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreAsosiasiRequest;
use App\Models\Dpl;
use App\Models\GuruPamong;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DashboardServiceController extends Controller
{
    public function storeAsosiasi(StoreAsosiasiRequest $request, $id){
        if($request->jenis_asosiasi == 2){
            return $this->storeAsosiasiDpl($id, $request->asosiasi_id);
        }
        else if($request->jenis_asosiasi == 3){
            return $this->storeAsosiasiGuruPamong($id, $request->asosiasi_id);
        }
    }

    public function getNilai($id){
        try {
            $mahasiswa = Mahasiswa::find($id);
            return $this->sendResponse($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 400, false, 'Gagal', $e->getMessage());
        }
    }

    private function storeAsosiasiDpl($id_mahasiswa, $id_dpl){
        try {
            $mahasiswa = Mahasiswa::find($id_mahasiswa);
            if(is_null($mahasiswa->id_guru_pamong)){
                return $this->sendResponse(null, 400, false, 'Gagal', 'Silahkan Hubungkan Guru Pamong Terlebih Dahulu');
            }
            else if(!is_null($mahasiswa->id_guru_pamong)){
                $guruPamong = GuruPamong::find($mahasiswa->id_guru_pamong);
                $guruPamong->id_dpl = $id_dpl;
                $guruPamong->save();

                return $this->sendResponse(null, 202, true, 'Berhasil', 'Berhasil Terhubung Dpl');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse(null, 400, false, 'Gagal', $e->getMessage());
        }
    }

    private function storeAsosiasiGuruPamong($id_mahasiswa, $id_guru_pamong){
        $mahasiswa = Mahasiswa::find($id_mahasiswa);
        if(is_null($mahasiswa->id_guru_pamong)){
            $mahasiswa->id_guru_pamong = $id_guru_pamong;
        }
        else if(!is_null($mahasiswa->id_guru_pamong)){
            $guruPamong = GuruPamong::find($mahasiswa->id_guru_pamong);
            if(!is_null($guruPamong->id_dpl)){
                $guruPamong->id_dpl = null;
                $guruPamong->save();
            }
            $mahasiswa->id_guru_pamong = $id_guru_pamong;
        }
        
        $mahasiswa->save();

        return $this->sendResponse(null, 202, true, 'Berhasil', 'Berhasil Terhubung Guru Pamong');
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
