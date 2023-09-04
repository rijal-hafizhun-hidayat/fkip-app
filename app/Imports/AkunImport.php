<?php

namespace App\Imports;

use App\Models\Dpl;
use App\Models\GuruPamong;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class AkunImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        if(request()->jenis_akun == 1){
            foreach($rows as $row){
                $idDpl = Dpl::where('nama', $row['nama'])->first();
                $isUserExist = User::where('nama', $row['nama'])->exists();
                if(!is_null($idDpl) && $isUserExist == false){
                    User::create([
                        'nama' => $row['nama'],
                        'username' => rand(1000, 9999),
                        'password' => '@dpl',
                        'role' => 2,
                        'id_dpl' => $idDpl->id,
                    ]);
                }
                else{
                    null;
                }
            }
        }
        else if(request()->jenis_akun == 2){
            foreach($rows as $row){
                $guruPamong = GuruPamong::where('nama', $row['nama'])->first();
                $isUserExist = User::where('nama', $row['nama'])->exists();
                if(!is_null($guruPamong) && $isUserExist == false){
                    User::create([
                        'nama' => $row['nama'],
                        'username' => rand(1000, 9999),
                        'password' => '@guru',
                        'role' => 3,
                        'id_guru_pamong' => $guruPamong->id,
                    ]);
                }
                else{
                    null;
                }
            }
        }
        else if(request()->jenis_akun == 3){
            foreach($rows as $row){
                $idMahasiswa = Mahasiswa::where('nama', $row['nama'])->first();
                $isUserExist = User::where('nama', $row['nama'])->exists();
                if(!is_null($idMahasiswa) && $isUserExist == false){
                    User::create([
                        'nama' => $row['nama'],
                        'username' => rand(1000, 9999),
                        'password' => '@mahasiswa',
                        'role' => 4,
                        'id_mahasiswa' => $idMahasiswa->id,
                    ]);
                }
                else{
                    null;
                }
            }
        }
    }
}
