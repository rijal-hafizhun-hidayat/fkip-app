<?php

namespace App\Http\Controllers\Akun\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akun\StoreAkunRequest;
use App\Http\Requests\Akun\UpdateAkunRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunService extends Controller
{
    public function getAkuns(Request $request){
        // $akuns = User::latest()->paginate(2);
        $queryAkun = User::latest();
        if($request->filled('nama')){
            $queryAkun->where('nama', 'like', '%'.$request->nama.'%');
        }
        $akuns = $queryAkun->paginate(2);
        return $this->responseService($akuns, 200, true, null, null);
    }

    public function store(StoreAkunRequest $request){
        User::create($request->validated());
        return $this->responseService(null, 200, true, 'Berhasil', 'Tambah Akun Berhasil');
    }

    public function update(UpdateAkunRequest $request,$id){
        $credential = $request->validated();
        if(isset($request->id_dpl)){
            $this->updateIdDpl($credential, $id);
        }
        else{
            $this->updateIdGuruPamong($credential, $id);
        }
        return $this->responseService(null, 200, true, 'Berhasil', 'Ubah Data Berhasil');
    }

    public function destroy($id){
        User::destroy($id);
        return $this->responseService(null, 200, true, 'Berhasil', 'hapus akun berhasil');
    }

    public function getAkunById($id){
        $akun = User::find($id);
        return $this->responseService($akun, 200, true, null, null);
    }

    public function getGuruPamongByIdGuruPamong($id){
        try {
            $guruPamong = DB::table('guru_pamong')->join('users', 'guru_pamong.id', '=', 'users.id_guru_pamong')->select('guru_pamong.id', 'guru_pamong.nama', 'guru_pamong.asal', 'guru_pamong.asal_sekolah')->where('users.id', $id)->get();
            return $this->responseService($guruPamong, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, null);
        }
    }

    public function getDplByIdDpl($id){
        try {
            $dpl = DB::table('dpl')->join('users', 'dpl.id', '=', 'users.id_dpl')->select('dpl.id', 'dpl.nipy', 'dpl.nama', 'dpl.email', 'dpl.prodi')->where('users.id', $id)->get();
            return $this->responseService($dpl, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, null);
        }
    }

    public function destroyAsosiasiGuruPamong($id){
        try {
            User::where('id', $id)->update(['id_guru_pamong' => null]);
            return $this->responseService(null, 200, true, 'Berhasil', 'berhasil hapus asosiasi guru pamong');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', 'gagal hapus asosiasi guru pamong');
        }
    }

    public function destroyAsosiasiDpl($id){
        try {
            User::where('id', $id)->update(['id_dpl' => null]);
            return $this->responseService(null, 200, true, 'Berhasil', 'berhasil hapus asosiasi dpl');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', 'gagal hapus asosiasi dpl');
        }
    }

    private function updateIdDpl($credential, $id){
        $user = User::find($id);
        $user->nama = $credential['nama'];
        $user->username = $credential['username'];
        $user->email = $credential['email'];
        $user->role = $credential['role'];
        $user->prodi = $credential['prodi'];
        $user->id_dpl = $credential['id_dpl'];
        $user->id_guru_pamong = null;

        return $user->save();
    }

    private function updateIdGuruPamong($credential, $id){
        $user = User::find($id);
        $user->nama = $credential['nama'];
        $user->username = $credential['username'];
        $user->email = $credential['email'];
        $user->role = $credential['role'];
        $user->prodi = $credential['prodi'];
        $user->id_dpl = null;
        $user->id_guru_pamong = $credential['id_guru_pamong'];

        return $user->save();
    }

    private function responseService($data, $code, $status, $title, $text){
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
