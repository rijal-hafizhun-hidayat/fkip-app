<?php

namespace App\Http\Controllers\Akun\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akun\ImportAkunRequest;
use App\Imports\AkunImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AkunImportService extends Controller
{
    public function import(ImportAkunRequest $request){
        Excel::import(new AkunImport, $request->excel);
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
