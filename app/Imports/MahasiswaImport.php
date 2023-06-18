<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class MahasiswaImport implements ToModel, WithUpserts
{
    public function model (array $row){
        return new Mahasiswa([
            'nim' => $row[0],
            'nama' => $row[1],
            'email' => $row[2],
            'prodi' => $row[3]
        ]);
    }

    public function uniqueBy()
    {
        return 'nim';
    }
}
