<?php

namespace App\Http\Controllers\Bimbingan\Service;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;

class BimbinganPdf extends Controller
{
    public function printPdf($id){
        $datas = Bimbingan::where('id_mahasiswa', $id)->get();
        $mahasiswa = Mahasiswa::find($id);
        $pdf = Pdf::loadView('pdf/print', [
            'mahasiswa' => $mahasiswa,
            'datas' => $datas
        ]);
        return $pdf->download('bimbingan.pdf');
    }
}
