<?php

namespace App\Http\Controllers\Guru_Pamong;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GuruPamongController extends Controller
{
    public function index(){
        return Inertia::render('Guru_Pamong/Index');
    }

    public function create(){
        return Inertia::render('Guru_Pamong/Create');
    }

    public function show($id){
        return Inertia::render('Guru_Pamong/Show', [
            'id' => $id,
            'prodis' => Prodi::all()
        ]);
    }

    public function addAsosiasiMahasiswa($id){
        return Inertia::render('Guru_Pamong/AddMahasiswa', [
            'id' => $id
        ]);
    }
}
