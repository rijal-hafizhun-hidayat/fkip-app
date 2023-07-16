<?php

namespace App\Http\Controllers\Guru_Pamong\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guru_Pamong\ImportGuruPamongRequest;
use App\Imports\GuruPamongImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuruPamongImportService extends Controller
{
    public function import(ImportGuruPamongRequest $request){
        Excel::import(new GuruPamongImport, $request->excel);
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
