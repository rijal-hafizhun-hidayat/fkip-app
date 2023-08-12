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
            $isDpl = Dpl::where('id', $row['id'])->first();
            if(is_null($isDpl)){
                Dpl::create([
                    'id' => $row['id'],
                    'nama' => $row['nama'],
                    'nipy' => $row['nipy'],
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
