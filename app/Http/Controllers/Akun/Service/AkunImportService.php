<?php

namespace App\Http\Controllers\Akun\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akun\ImportAkunRequest;
use App\Imports\AkunDplImport;
use App\Imports\AkunGuruPamongImport;
use App\Imports\AkunMahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class AkunImportService extends Controller
{
    public function importAkunDpl(ImportAkunRequest $request){
        //dd('ini import akun dpl', $request->excel);
        Excel::import(new AkunDplImport, $request->excel);
        return $this->responseService(null, 200, true, 'Berhasil', 'berhasil import data');
    }

    public function importAkunGuruPamong(ImportAkunRequest $request){
        //dd('ini import akun guru pamong', $request->excel);
        Excel::import(new AkunGuruPamongImport, $request->excel);
        return $this->responseService(null, 200, true, 'Berhasil', 'berhasil import data');
    }

    public function importAkunMahasiswa(ImportAkunRequest $request){
        //dd('ini import akun mahasiswa', $request->excel);
        Excel::import(new AkunMahasiswaImport, $request->excel);
        return $this->responseService(null, 200, true, 'Berhasil', 'berhasil import data');
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
