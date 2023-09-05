<?php

namespace App\Imports;

use App\Models\Dpl;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AkunDplImport implements ToModel, WithHeadingRow, WithChunkReading
{
    private $dpl;
    public function __construct()
    {
        $this->dpl = Dpl::select('id', 'nama')->get();
    }

    public function model(array $rows)
    {
        $dpl = $this->dpl->where('nama', $rows['nama'])->first();
        return new User([
            'nama' => $rows['nama'],
            'username' => $rows['niy'] . '@dpl',
            'password' => '@dpl',
            'role' => 2,
            'id_dpl' => $dpl->id ?? null
        ]);  
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
