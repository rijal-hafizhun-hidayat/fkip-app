<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akun\RegisterAkunRequest;
use App\Models\GuruPamong;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'mahasiswas' => Mahasiswa::all(),
            'guru_pamongs' => GuruPamong::all()
        ]);
    }

    public function store(RegisterAkunRequest $request)
    {

        $user = User::create([
            'nama_depan' => $request->nama_depan,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password,
            'role' => $request->role,
            'email' => $request->email,
            'id_guru_pamong' => $request->id_guru_pamong ?? null,
            'id_mahasiswa' => $request->id_mahasiswa ?? null
        ]);

        Auth::login($user);

        return $this->sendResponse(null, 200, true, 'Berhasil', 'Berhasil membuat Akun');
    }

    private function sendResponse($data, $code, $status, $title, $text){
        $response = [
            'data' => $data,
            'code' => $code,
            'status' => $status,
            'title' => $title,
            'text' => $text
        ];

        return response()->json($response, $code);
    }
}
