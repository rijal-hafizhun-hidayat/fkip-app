<?php

namespace App\Imports;

use App\Models\GuruPamong;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruPamongImport implements ToModel, WithHeadingRow
{
    public function model(array $row){
        return new GuruPamong([
            'nama' => $row['nama'],
            'asal_sekolah' => $row['asal_sekolah'],
            'bidang_keahlian' => $row['bidang_keahlian']
        ]);
    }
}
