<?php

namespace App\Imports;

use App\Models\Dpl;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class DplImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            $isDpl = Dpl::where('nama', $row['nama'])->first();
            if(is_null($isDpl)){
                Dpl::create([
                    'nama' => $row['nama'],
                    'nipy' => rand(1000, 9999),
                    'prodi' => $row['prodi'],
                    'jenis_plp' => $row['jenis_plp']
                ]);
            }
            else{
                null;
            }
        }
    }
}
