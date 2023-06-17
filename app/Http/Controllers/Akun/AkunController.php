<?php

namespace App\Http\Controllers\Akun;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAkunsRequest;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AkunController extends Controller
{
    public function index(){
        return Inertia::render('Akun/Index');
    }

    public function create(){
        return Inertia::render('Akun/Create', [
            'prodis' => Prodi::all()
        ]);
    }

    public function show($id){
        return Inertia::render('Akun/Edit', [
            'id' => $id,
            'prodis' => Prodi::all()
        ]);
    }
}
