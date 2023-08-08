<?php

namespace App\Imports;

use App\Models\Dpl;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DplImport implements ToModel, WithUpserts, WithHeadingRow
{
    public function model(array $row)
    {
        return new Dpl([
            'nama' => $row['nama'],
            'nipy' => $row['nipy'],
            'prodi' => $row['prodi']
        ]);
    }

    public function uniqueBy()
    {
        return 'nipy';
    }
}
