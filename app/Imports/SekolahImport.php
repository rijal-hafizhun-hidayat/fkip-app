<?php

namespace App\Imports;

use App\Models\Sekolah;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SekolahImport implements ToCollection, WithHeadingRow
{
    public function collection (Collection $rows){
        foreach($rows as $row){
            $isSekolah = Sekolah::where('nama', $row['nama'])->first();
            if(is_null($isSekolah)){
                Sekolah::create([
                    'nama' => $row['sekolah'],
                    'jenis_plp' => $row['jenis_plp'],
                ]);
            }
            else{
                null;
            }
        }
    }
}
