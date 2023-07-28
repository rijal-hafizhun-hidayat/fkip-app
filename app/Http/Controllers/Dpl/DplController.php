<?php

namespace App\Http\Controllers\Dpl;

use App\Http\Controllers\Controller;
use App\Models\Dpl;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DplController extends Controller
{
    public function index(){
        return Inertia::render('Dpl/Index');
    }

    public function create(){
        return Inertia::render('Dpl/Create', [
            'prodis' => Prodi::all(),
            'dpls' => Dpl::all()
        ]);
    }

    public function show($id){
        return Inertia::render('Dpl/Show', [
            'prodis' => Prodi::all(),
            'dpls' => Dpl::all(),
            'id' => $id
        ]);
    }

    public function dplGuruPamongMahasiswa($id){
        //dd($id);
        return Inertia::render('Dpl/AddGuruPamongMahasiswa', [
            'id' => $id
        ]);
    }
}
