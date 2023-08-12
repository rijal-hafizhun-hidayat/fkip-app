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
            $isSekolah = Sekolah::where('id', $row['id'])->first();
            if(is_null($isSekolah)){
                Sekolah::create([
                    'id' => $row['id'],
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
