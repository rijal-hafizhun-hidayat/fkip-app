<?php

namespace App\Http\Controllers\Mahasiswa\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mahasiswa\ImportMahasiswaRequest;
use App\Imports\MahasiswaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaImportService extends Controller
{
    public function import(ImportMahasiswaRequest $request){
        //dd($request->excel);
        Excel::import(new MahasiswaImport, $request->excel);
        return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Import Data');
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
