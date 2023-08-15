<?php

namespace App\Imports;

use App\Models\GuruPamong;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruPamongImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows){
        foreach($rows as $row){
            $isGuruPamong = GuruPamong::where('id', $row['id'])->first();
            $isSameNamaGuruPamong = GuruPamong::where('nama', $row['nama'])->first();
            if(is_null($isGuruPamong) && is_null($isSameNamaGuruPamong)){
                GuruPamong::create([
                    'id' => $row['id'],
                    'nama' => $row['nama'],
                    'asal_sekolah' => $row['asal_sekolah'],
                    'bidang_keahlian' => $row['bidang_keahlian'],
                ]);
            }
            else{
                null;
            }
        }
    }
}
