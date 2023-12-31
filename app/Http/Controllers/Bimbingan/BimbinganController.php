<?php

namespace App\Http\Controllers\Bimbingan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BimbinganController extends Controller
{
    public function index($id){
        //dd($id, $idDpl);
        return Inertia::render('Bimbingan/Index', [
            'id' => $id
        ]);
    }

    public function create($id){
        return Inertia::render('Bimbingan/Create', [
            'id' => $id,
        ]);
    }
}
