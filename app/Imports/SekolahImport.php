<?php

namespace App\Imports;

use App\Models\Sekolah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SekolahImport implements ToModel, WithHeadingRow
{
    public function model (array $row){
        return new Sekolah([
            'nama' => $row['sekolah'],
            'jenis_plp' => $row['jenis_plp']
        ]);
    }
}
