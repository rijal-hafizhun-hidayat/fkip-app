<?php

namespace App\Imports;

use App\Models\Dpl;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;

class DplImport implements ToModel, WithUpserts
{
    public function model(array $row)
    {
        return new Dpl([
            'nama' => $row[1],
            'nipy' => $row[0],
            'email' => $row[2],
            'prodi' => $row[3]
        ]);
    }

    public function uniqueBy()
    {
        return 'nipy';
    }
}
