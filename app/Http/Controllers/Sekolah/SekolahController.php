<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SekolahController extends Controller
{
    public function index(){
        return Inertia::render('Sekolah/Index');
    }

    public function create(){
        return Inertia::render('Sekolah/Create');
    }

    public function show($id){
        return Inertia::render('Sekolah/Show', [
            'id' => $id
        ]);
    }
}
