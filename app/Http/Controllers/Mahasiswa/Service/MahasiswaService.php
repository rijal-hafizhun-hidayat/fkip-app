<?php

namespace App\Http\Controllers\Mahasiswa\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mahasiswa\StoreMahasiswaRequest;
use App\Http\Requests\Mahasiswa\UpdateIdDplRequest;
use App\Http\Requests\Mahasiswa\UpdateMahasiswaRequest;
use App\Http\Requests\Mahasiswa\UpdateNilaiMahasiswa;
use App\Models\Bimbingan;
use App\Models\Dpl;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use App\Models\Nilai_nb;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class MahasiswaService extends Controller
{
    public function getMahasiswa(Request $request){
        try {
            $queryMahasiswa = Mahasiswa::latest();
            if($request->filled('nama')){
                $queryMahasiswa->where('nama', 'like', '%'.$request->nama.'%');
            }
            if($request->filled('jenis_plp')){
                $queryMahasiswa->where('jenis_plp', $request->jenis_plp);
            }
            $mahasiswa = $queryMahasiswa->paginate(10);
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e);
        }
    }

    public function getMahasiswaByIdAkun(Request $request, $id){
        try {
            $queryMahasiswa = Mahasiswa::latest()->where('id_guru_pamong', $id);
            if($request->filled('nama')){
                $queryMahasiswa->where('nama', 'like', '%'.$request->nama.'%');
            }
            $mahasiswa = $queryMahasiswa->paginate(1);
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e);
        }
    }

    public function getMahasiswaById($id){
        try {
            $mahasiswa = Mahasiswa::find($id);
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e);
        }
    }

    public function getNilaiMahasiswaByIdMahasiswa($id){
        try {
            $nilai = Nilai::where('id_mahasiswa', $id)->first();
            return $this->responseService($nilai, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e->getMessage());
        }
    }

    public function store(StoreMahasiswaRequest $request){
        try {
            Mahasiswa::create($request->validated());
            //dd($mahasiswa->id);
            // Nilai::create([
            //     'id_mahasiswa' => $mahasiswa->id,
            //     'jenis_plp' => $mahasiswa->jenis_plp,
            // ]);
            return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Tambah Mahasiswa');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e->getMessage());
        }
    }

    public function update(UpdateMahasiswaRequest $request, $id){
        try {
            Mahasiswa::where('id', $id)->update($request->validated());
            return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Ubah Mahasiswa');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e->getMessage());
        }
    }

    public function destroy($id){
        Mahasiswa::destroy($id);
        return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Hapus Mahasiswa');
    }

    public function updateNilai(Request $request, $id){
        //dd($request->all());
        $data = $this->setNilai($request->all(), $id);
        //dd($data);
        try {
            Mahasiswa::where('id', $id)->update(
                [
                    $request->jenis_nilai_kompeten => $data['nilai_kompeten'],
                    $request->jenis_nilai => $data[$request->jenis_nilai],
                    'nilai' => $data['total_nilai']
                ],
            );
            return $this->responseService(null, 200, true, 'Berhasil', 'Berhasil Update Nilai');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e);
        }
    }

    public function getPertanyaanByJenisPlpJenisBidangJenisPertanyaan($jenisPlp, $jenisBidang, $jenisPertanyaan){
        //dd($jenisPlp, $jenisBidang, $jenisPertanyaan);
        try {
            $pertanyaan = Pertanyaan::where([
                ['jenis_plp', $jenisPlp],
                ['jenis_studi', $jenisBidang],
                ['jenis_kalimat', $jenisPertanyaan]
            ])->get();
            return $this->responseService($pertanyaan, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e->getMessage());
        }
    }

    public function getMahasiswaNilaiById($id){
        try {
            $mahasiswa = Nilai::join('mahasiswa', 'nilai.id_mahasiswa', '=', 'mahasiswa.id')->select('mahasiswa.nim', 'mahasiswa.nama', 'nilai.*')->where('nilai.id_mahasiswa', $id)->first();
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e->getMessage());
        }
    }

    public function getNilaiKomponenByIdMahasiswa($jenis_plp, $id){
        try {
            $nilai = Mahasiswa::where([
                ['id', $id],
                ['jenis_plp', $jenis_plp],
            ])->first();
            return $this->responseService($nilai, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e->getMessage());
        }
    }
    
    public function getDplMahasiswaById($id){
        try {
            $dpl = Dpl::join('mahasiswa', 'dpl.id', '=', 'mahasiswa.id_dpl')->select('dpl.*')->where('mahasiswa.id', $id)->get();
            return $this->responseService($dpl, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e->getMessage());
        }
    }

    public function updateIdDpl(UpdateIdDplRequest $request, $id){
        try {
            Mahasiswa::where('id', $id)->update($request->all());
            //$this->setIdDplInBimbingan($id);
            return $this->responseService(null, 200, true, 'berhasil', 'update dpl berhasil');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e->getMessage());
        }
    }

    public function destroyAsosiasiDpl($id){
        try {
            Mahasiswa::where('id', $id)->update(['id_dpl' => null]);
            return $this->responseService(null, 200, true, 'berhasil', 'berhasil hapus asosiasi dpl');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e->getMessage());
        }
    }

    private function setIdDplInBimbingan($id){
        $queryBimbingan = $this->isBimbinganNotNull($id);

        if($queryBimbingan != true){
            //dd(true);
            $bimbingan = Bimbingan::where('id_mahasiswa', $id)->first();
 
            $bimbingan->id_mahasiswa = $id;
            $bimbingan->id_dpl = request()->id_dpl;
            
            $bimbingan->save();
        }
        else{
            //dd(false);
            $bimbingan = new Bimbingan;

            $bimbingan->keterangan_bimbingan = '';
            $bimbingan->link = '';
            $bimbingan->id_mahasiswa = $id;
            $bimbingan->id_dpl = request()->id_dpl;
            
            return $bimbingan->save();
        }

        
    }

    private function isBimbinganNotNull($id){
        $queryBimbingan = Bimbingan::where('id', $id)->whereNotNull('created_at')->first();
        if($queryBimbingan == null){
            $result = true;
        }
        else{
            $result = false;
        }

        return $result;
    }

    private function setJenisPlpNilaiMahasiswa($jenis_plp, $id){
        try {
            Nilai::where('id_mahasiswa', $id)->update(['jenis_plp' => $jenis_plp]);
            $isTrue = true;
        } catch (\Illuminate\Database\QueryException $e) {
            $isTrue = false;
        }

        return $isTrue;
    }

    private function setNilai($credential, $id){
        $resultCredential = $this->setJenisNilai($credential);
        $resultCredential['total_nilai'] = $this->setTotalNilai($resultCredential, $id);
        return $resultCredential;
    }

    private function setTotalNilai($resultCredential, $id){
        $totalNilai = null;
        $nilaiKompeten = $this->getNilai($resultCredential, $id);
        //dd($resultCredential, $nilaiKompeten);
        if($resultCredential['jenis_bidang'] == 'bk'){
            //dd('bk');
            if($resultCredential['jenis_nilai'] == 'nilai_ne' && $nilaiKompeten['nilai_ne'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $resultCredential['nilai_ne']) / 4;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nd' && $nilaiKompeten['nilai_nd'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $resultCredential['nilai_nd'] + $nilaiKompeten['nilai_ne']) / 4;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nc' && $nilaiKompeten['nilai_nc'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $resultCredential['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne']) / 4;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] == null){
                $totalNilai = ($resultCredential['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne']) / 4;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_ne' && $nilaiKompeten['nilai_ne'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $resultCredential['nilai_ne']) / 4;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nd' && $nilaiKompeten['nilai_nd'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $resultCredential['nilai_nd'] + $nilaiKompeten['nilai_ne']) / 4;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nc' && $nilaiKompeten['nilai_nc'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $resultCredential['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne']) / 4;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] != null){
                $totalNilai = ($resultCredential['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne']) / 4;
            }
        }
        else if($resultCredential['jenis_bidang'] == 'pgpaud'){
            //dd($nilaiKompeten);
            if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] == null){
                $totalNilai = ($resultCredential['nilai_nb'] + $nilaiKompeten['nilai_nd']) / 2;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nd' && $nilaiKompeten['nilai_nd'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $resultCredential['nilai_nd']) / 2;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] != null){
                $totalNilai = ($resultCredential['nilai_nb'] + $nilaiKompeten['nilai_nd']) / 2;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nd' && $nilaiKompeten['nilai_nd'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $resultCredential['nilai_nd']) / 2;
            }
        }
        else if($resultCredential['jenis_bidang'] == 'teaching'){
            //dd('teaching');
            if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] == null){
                $totalNilai = ($resultCredential['nilai_nb'] + $nilaiKompeten['nilai_nc']) / 2;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nc' && $nilaiKompeten['nilai_nc'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $resultCredential['nilai_nc']) / 2;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] != null){
                $totalNilai = ($resultCredential['nilai_nb'] + $nilaiKompeten['nilai_nc']) / 2;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nc' && $nilaiKompeten['nilai_nc'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $resultCredential['nilai_nc']) / 2;
            }
        }
        

        return $totalNilai;
    }

    private function getNilai($credential, $id){
        try {
            $getNilaiKompeten = Mahasiswa::where([
                ['id', $id],
                ['jenis_plp', $credential['jenis_plp']],
            ])->first();
        } catch (\Illuminate\Database\QueryException $e) {
            $getNilaiKompeten = false;
        }

        return $getNilaiKompeten;
    }

    private function setJenisNilai($credential){
        $jenisNilai = $credential['jenis_nilai'];

        if($credential['jenis_nilai'] == 'nilai_nb' && $credential['jenis_bidang'] == 'teaching'){
            $credential[$jenisNilai] = $this->setNilaiNbTeaching($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nc' && $credential['jenis_bidang'] == 'teaching'){
            $credential[$jenisNilai] = $this->setNilaiNcTeaching($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nd' && $credential['jenis_bidang'] == 'teaching'){
            $credential[$jenisNilai] = $this->setNilaiNdTeaching($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nb' && $credential['jenis_bidang'] == 'bk'){
            $credential[$jenisNilai] = $this->setNilaiNbBk($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nc' && $credential['jenis_bidang'] == 'bk'){
            $credential[$jenisNilai] = $this->setNilaiNcBk($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nd' && $credential['jenis_bidang'] == 'bk'){
            $credential[$jenisNilai] = $this->setNilaiNdBk($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_ne' && $credential['jenis_bidang'] == 'bk'){
            $credential[$jenisNilai] = $this->setNilaiNeBk($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nb' && $credential['jenis_bidang'] == 'pgpaud'){
            $credential[$jenisNilai] = $this->setNilaiNbPgpaud($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nd' && $credential['jenis_bidang'] == 'pgpaud'){
            $credential[$jenisNilai] = $this->setNilaiNdPgpaud($credential);
        }

        //dd($credential);

        return $credential;
    }

    private function setNilaiNbPgpaud($credential){
        $totalPoint = null;

        for ($i=0; $i < count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 24) * 100;
        
        return $hasil;
    }

    private function setNilaiNdPgpaud($credential){
        $totalPoint = null;

        for ($i=0; $i < count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 104) * 100;
        
        return $hasil;
    }

    private function setNilaiNbBk($credential){
        $totalPoint = null;

        //dd($credential['nilai_kompeten']);
        for ($i=0; $i < count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 72) * 100;
        //dd($hasil);
        return $hasil;
    }

    private function setNilaiNcBk($credential){
        $totalPoint = null;

        for ($i=0; $i < count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 112) * 100;

        return round($hasil, 2);
    }

    private function setNilaiNdBk($credential){
        $totalPoint = null;
        //dd(count($credential['nilai_kompeten']), $credential['nilai_kompeten']);

        for ($i=0; $i < count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 56) * 100;

        return round($hasil, 2);
    }

    private function setNilaiNeBk($credential){
        $totalPoint = null;
        //dd($credential);
        for ($i=0; $i < count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 116) * 100;

        return round($hasil, 2);
    }

    private function setNilaiNbTeaching($credential){
        $totalPoint = null;

        for ($i=0; $i < count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 20) * 100;

        return $hasil; 
    }

    private function setNilaiNcTeaching($credential){
        $totalPoint = null;

        for ($i=0; $i < count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 52) * 100;

        return round($hasil, 2);
    }

    private function setNilaiNdTeaching($credential){
        $totalPoint = null;

        for ($i=0; $i < count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 52) * 100;

        return round($hasil, 2);
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
