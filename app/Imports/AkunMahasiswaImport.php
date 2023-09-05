<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AkunMahasiswaImport implements ToModel, WithHeadingRow, WithChunkReading
{

    private $mahasiswa;
    public function __construct()
    {
        $this->mahasiswa = Mahasiswa::select('id', 'nama')->get();
    }

    public function model(array $rows)
    {
        $mahasiswa = $this->mahasiswa->where('nama', $rows['nama'])->first();
        return new User([
            'nama' => $rows['nama'],
            'username' => $rows['nim'] . '@mahasiswa',
            'password' => '@mahasiswa',
            'role' => 4,
            'id_mahasiswa' => $mahasiswa->id ?? null
        ]);
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
