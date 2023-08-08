<?php

namespace App\Http\Controllers\Guru_Pamong;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\Sekolah;
use Inertia\Inertia;

class GuruPamongController extends Controller
{
    public function index(){
        return Inertia::render('Guru_Pamong/Index', [
            'sekolahs' => Sekolah::all(),
            'prodis' => Prodi::all()
        ]);
    }

    public function create(){
        return Inertia::render('Guru_Pamong/Create', [
            'sekolahs' => Sekolah::all()
        ]);
    }

    public function show($id){
        return Inertia::render('Guru_Pamong/Show', [
            'id' => $id,
            'prodis' => Prodi::all(),
            'sekolahs' => Sekolah::all()
        ]);
    }

    public function createAsosiasiMahasiswa($id){
        return Inertia::render('Guru_Pamong/AddMahasiswa', [
            'id' => $id
        ]);
    }

    public function showNilaiMahasiswa($id){{
        return Inertia::render('Mahasiswa/Nilai', [
            'id' => $id
        ]);
      }}
}
