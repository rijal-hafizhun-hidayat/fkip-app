<?php

namespace App\Http\Controllers\Akun;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAkunsRequest;
use App\Models\Dpl;
use App\Models\GuruPamong;
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
            'guruPamongs' => GuruPamong::all(),
            'dpls' => Dpl::all(),
            'prodis' => Prodi::all()
        ]);
    }

    public function show($id){
        $role = User::find($id);
        return Inertia::render('Akun/Edit', [
            'id' => $id,
            'prodis' => Prodi::all(),
            'guruPamongs' => GuruPamong::all(),
            'dpls' => Dpl::all(),
            'roleAkun' => $role->role
        ]);
    }

    public function addMhs($id){
        return Inertia::render('Akun/AddMhs', [
            'id' => $id
        ]);
    }
}
