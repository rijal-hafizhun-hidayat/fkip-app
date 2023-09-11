<?php

namespace App\Http\Controllers\Akun\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akun\ResetPassAkunRequest;
use App\Http\Requests\Akun\StoreAkunRequest;
use App\Http\Requests\Akun\UpdateAkunRequest;
use App\Models\Dpl;
use App\Models\GuruPamong;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunService extends Controller
{
    public function getAkuns(Request $request){
        $queryAkun = User::latest();
        if($request->filled('nama')){
            $queryAkun->where('nama', 'like', '%'.$request->nama.'%');
        }
        $akuns = $queryAkun->paginate(10);
        return $this->responseService($akuns, 200, true, null, null);
    }

    public function store(StoreAkunRequest $request){
        if($request->role == User::ROLE_ID_ADMIN){
            $this->storeAkunAdmin($request->all());
        }
        else if($request->role == User::ROLE_DPL_ID){
            $this->storeAkunDpl($request->all());
        }
        else if($request->role == User::ROLE_ID_GURU_PAMONG){
            $this->storeAkunGuruPamong($request->all());
        }
        else if($request->role == User::ROLE_ID_MAHASISWA){
            $this->storeAkunMahasiswa($request->all());
        }
        
        return $this->responseService(null, 200, true, 'Berhasil', 'Tambah Akun Berhasil');
    }

    public function update(UpdateAkunRequest $request,$id){
        $credential = $request->validated();
        if($request->role == User::ROLE_ID_ADMIN){
            $this->updateAkunAdmin($credential, $id);
        }
        else if($request->role == User::ROLE_DPL_ID){
            $this->updateAkunDpl($credential, $id);
        }
        else if($request->role == User::ROLE_ID_GURU_PAMONG){
            $this->updateAkunGuruPamong($credential, $id);
        }
        else if($request->role == User::ROLE_ID_MAHASISWA){
            $this->updateAkunMahasiswa($credential, $id);
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
            $user = User::find($id);
            $guruPamong = GuruPamong::find($user->id_guru_pamong);
            return $this->responseService($guruPamong, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, null);
        }
    }

    public function getDplByIdDpl($id){
        try {
            $user = User::find($id);
            $dpl = Dpl::find($user->id_dpl);
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

    public function resetPass(ResetPassAkunRequest $request, $id){
        try {
            $queryResetPassUser = User::find($id);
            $queryResetPassUser->password = Hash::make($request->password);
            $queryResetPassUser->save();
            return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Ubah Password');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e->getMessage());
        }
    }

    public function getProdi($prodi){
        try {
            $namaProdi = Prodi::where('nama', $prodi)->orWhere('bidang_keahlian', $prodi)->first();
            return $this->responseService($namaProdi, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e->getMessage());
        }
    }

    private function storeAkunAdmin($credential){
        return User::create([
            'nama_depan' => $credential['nama_depan'],
            'nama' => $credential['nama'],
            'username' => $credential['username'],
            'password' => $credential['password'],
            'email' => $credential['email'],
            'role' => $credential['role']
        ]);
    }

    private function storeAkunDpl($credential){
        //dd($credential, $credential['nama_depan']);
        return User::create([
            'nama_depan' => $credential['nama_depan'],
            'nama' => $credential['nama'],
            'username' => $credential['username'],
            'password' => $credential['password'],
            'email' => $credential['email'],
            'role' => $credential['role'],
            'id_dpl' => $credential['id_dpl']
        ]);
    }

    private function storeAkunGuruPamong($credential){
        return User::create([
            'nama_depan' => $credential['nama_depan'],
            'nama' => $credential['nama'],
            'username' => $credential['username'],
            'password' => $credential['password'],
            'email' => $credential['email'],
            'role' => $credential['role'],
            'id_guru_pamong' => $credential['id_guru_pamong']
        ]);
    }

    private function storeAkunMahasiswa($credential){
        return User::create([
            'nama_depan' => $credential['nama_depan'],
            'nama' => $credential['nama'],
            'username' => $credential['username'],
            'password' => $credential['password'],
            'email' => $credential['email'],
            'role' => $credential['role'],
            'id_mahasiswa' => $credential['id_mahasiswa']
        ]);
    }

    private function updateAkunAdmin($credential, $id){
        $user = User::find($id);
        $user->nama_depan = $credential['nama_depan'];
        $user->nama = $credential['nama'];
        $user->username = $credential['username'];
        $user->email = $credential['email'];
        $user->role = $credential['role'];
        $user->id_dpl = null;
        $user->id_guru_pamong = null;
        $user->id_mahasiswa = null;

        return $user->save();
    }

    private function updateAkunDpl($credential, $id){
        $user = User::find($id);
        $user->nama_depan = $credential['nama_depan'];
        $user->nama = $credential['nama'];
        $user->username = $credential['username'];
        $user->email = $credential['email'];
        $user->role = $credential['role'];
        $user->id_dpl = $credential['id_dpl'];
        $user->id_guru_pamong = null;
        $user->id_mahasiswa = null;

        return $user->save();
    }

    private function updateAkunGuruPamong($credential, $id){
        $user = User::find($id);
        $user->nama_depan = $credential['nama_depan'];
        $user->nama = $credential['nama'];
        $user->username = $credential['username'];
        $user->email = $credential['email'];
        $user->role = $credential['role'];
        $user->id_dpl = null;
        $user->id_guru_pamong = $credential['id_guru_pamong'];
        $user->id_mahasiswa = null;

        return $user->save();
    }

    private function updateAkunMahasiswa($credential, $id){
        $user = User::find($id);
        $user->nama_depan = $credential['nama_depan'];
        $user->nama = $credential['nama'];
        $user->username = $credential['username'];
        $user->email = $credential['email'];
        $user->role = $credential['role'];
        $user->id_dpl = null;
        $user->id_guru_pamong = null;
        $user->id_mahasiswa = $credential['id_mahasiswa'];  

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
