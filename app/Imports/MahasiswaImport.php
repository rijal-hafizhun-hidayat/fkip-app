<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithUpserts, WithHeadingRow
{
    public function model (array $row){
        return new Mahasiswa([
            'nim' => $row['nim'],
            'nama' => $row['nama'],
            'email' => $row['email'],
            'prodi' => $row['prodi']
        ]);
    }

    public function uniqueBy()
    {
        return 'nim';
    }
}
