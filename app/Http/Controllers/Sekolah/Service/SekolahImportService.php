<?php

namespace App\Http\Controllers\Sekolah\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sekolah\ImportSekolahRequest;
use App\Imports\SekolahImport;
use Maatwebsite\Excel\Facades\Excel;

class SekolahImportService extends Controller
{
    public function import(ImportSekolahRequest $request){
        Excel::import(new SekolahImport, $request->excel);
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
