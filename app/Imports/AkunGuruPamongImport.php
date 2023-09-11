<?php

namespace App\Imports;

use App\Models\GuruPamong;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AkunGuruPamongImport implements ToModel, WithHeadingRow, WithChunkReading
{
    private $guruPamong;
    public function __construct()
    {
        $this->guruPamong = GuruPamong::select('id', 'nama')->get();
    }
    public function model(array $rows)
    {
        $guruPamong = $this->guruPamong->where('nama', $rows['nama'])->first();
        return new User([
            'nama' => $rows['nama'],
            'username' => rand(1000, 9999) . '@guru',
            'password' => '@guru',
            'email' => $rows['email'],
            'role' => 3,
            'id_guru_pamong' => $guruPamong->id ?? null
        ]);
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
