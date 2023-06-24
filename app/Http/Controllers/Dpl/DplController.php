<?php

namespace App\Http\Controllers\Dpl;

use App\Http\Controllers\Controller;
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
            'prodis' => Prodi::all()
        ]);
    }

    public function show($id){
        return Inertia::render('Dpl/Show', [
            'prodis' => Prodi::all(),
            'id' => $id
        ]);
    }
}
