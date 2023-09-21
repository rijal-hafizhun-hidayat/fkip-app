<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows){
        foreach($rows as $row){
            $isMahasiswa = Mahasiswa::where('nim', $row['nim'])->first();
            if(is_null($isMahasiswa)){
                Mahasiswa::create([
                    'nim' => $row['nim'],
                    'nama' => $row['nama'],
                    'prodi' => $row['prodi'],
                    'jenis_plp' => $row['jenis_plp'],
                ]);
            }
            else{
                null;
            }
        }
    }
}
