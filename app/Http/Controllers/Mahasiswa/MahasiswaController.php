<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MahasiswaController extends Controller
{
    public function index(){
        return Inertia::render('Mahasiswa/Index');
    }

    public function create(){
        return Inertia::render('Mahasiswa/Create', [
            'prodis' => Prodi::all()
        ]);
    }

    public function show($id){
        return Inertia::render('Mahasiswa/Edit', [
            'prodis' => Prodi::all(),
            'id' => $id
        ]);
    }
}
