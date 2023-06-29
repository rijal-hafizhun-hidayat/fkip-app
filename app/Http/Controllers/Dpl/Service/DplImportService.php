<?php

namespace App\Http\Controllers\Dpl\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dpl\ImportDplRequest;
use App\Imports\DplImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DplImportService extends Controller
{
    public function import(ImportDplRequest $request){
        //dd($request->excel);
        Excel::import(new DplImport, $request->excel);
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
