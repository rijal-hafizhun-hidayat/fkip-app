<?php

namespace App\Imports;

use App\Models\GuruPamong;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruPamongImport implements ToModel, WithHeadingRow
{
    public function model(array $row){
        return new GuruPamong([
            'nama' => $row['nama'],
            'asal' => $row['asal'],
            'asal_sekolah' => $row['asal_sekolah'],
            'bidang_keahlian' => $row['bidang_keahlian']
        ]);
    }
}
