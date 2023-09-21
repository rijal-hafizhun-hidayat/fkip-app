<?php

namespace App\Http\Controllers\Mahasiswa\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mahasiswa\StoreMahasiswaRequest;
use App\Http\Requests\Mahasiswa\UpdateIdDplRequest;
use App\Http\Requests\Mahasiswa\UpdateMahasiswaRequest;
use App\Models\Bimbingan;
use App\Models\Dpl;
use App\Models\GuruPamong;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class MahasiswaService extends Controller
{
    public function getMahasiswa(){
        try {
            $queryMahasiswa = $this->setQueryMahasiswa();
            $mahasiswa = $queryMahasiswa->paginate(10);
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e);
        }
    }

    public function getMahasiswaNoPaginate(){
        try {
            $mahasiswa = Mahasiswa::where('id_dpl', null)->get();
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e->getMessage());
        }
    }

    public function getMahasiswaByIdAkun($id){
        try {
            $queryMahasiswa = $this->setQueryMahasiswaByIdAkun($id);
            $mahasiswa = $queryMahasiswa->get();
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, 'Gagal', $e);
        }
    }

    public function getMahasiswaBimbinganByIdDpl($id){
        try {
            $queryMahasiswa = $this->setQueryMahasiswaBimbinganByIdDpl($id);
            $mahasiswa = $queryMahasiswa->get();
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 400, false, null, $e->getMessage());
        }
    }

    public function getMahasiswaByIdDpl($id){
        try {
            $queryMahasiswa = $this->setQueryMahasiswaByIdDpl($id);
            $mahasiswa = $queryMahasiswa->get();
            return $this->responseService($mahasiswa, 200, true, null, null);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->responseService(null, 404, false, 'gagal', $e->getMessage());
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
        $data = $this->setNilai($request->all(), $id);
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
        try {
            if(($jenisPlp == 'plp_1' || $jenisPlp == 'km_plp_1') && $jenisPertanyaan != 'ns'){
                $pertanyaan = $this->getPertanyaanByPlpOne();
            }
            else if(($jenisPlp == 'plp_2' || $jenisPlp == 'km_plp_2') && $jenisPertanyaan == 'ns'){
                $pertanyaan = $this->getPertanyaanByNs();
            }
            else if($jenisPlp == 'plp_2' || $jenisPlp == 'km_plp_2'){
                $pertanyaan = $this->getPertanyaanByPlpTwo($jenisBidang, $jenisPertanyaan);
            }
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

    public function getNilaiKomponenByIdMahasiswa($id){
        try {
            $nilai = Mahasiswa::where('id', $id)->first();
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

    private function setQueryMahasiswaByIdAkun($id){
        $dBMahasiswa = Mahasiswa::where('id_guru_pamong', $id)->latest();

        if(request()->filled('nama')){
            $dBMahasiswa->where('nama', 'like', '%'.request()->nama.'%');
        }
        if(request()->filled('jenis_plp')){
            $dBMahasiswa->where('jenis_plp', request()->jenis_plp);
        }
        if(request()->filled('prodi')){
            $dBMahasiswa->where('prodi', request()->prodi);
        }
        if(request()->is_nilai == 'ada'){
            $dBMahasiswa->whereNotNull('nilai');
        }
        if(request()->is_nilai == 'tidak'){
            $dBMahasiswa->whereNull('nilai');
        }

        return $dBMahasiswa;
    }

    private function setQueryMahasiswaByIdDpl($id){
        $dBMahasiswa = Mahasiswa::where('id_dpl', $id);

        if(request()->filled('nama')){
            $dBMahasiswa->where('nama', 'like', '%'.request()->nama.'%');
        }
        if(request()->filled('jenis_plp')){
            $dBMahasiswa->where('jenis_plp', request()->jenis_plp);
        }
        if(request()->filled('prodi')){
            $dBMahasiswa->where('prodi', request()->prodi);
        }
        if(request()->is_nilai == 'ada'){
            $dBMahasiswa->whereNotNull('nilai');
        }
        if(request()->is_nilai == 'tidak'){
            $dBMahasiswa->whereNull('nilai');
        }

        return $dBMahasiswa;
    }

    private function setQueryMahasiswaBimbinganByIdDpl($id){
        $dBMahasiswa = GuruPamong::join('mahasiswa', 'guru_pamong.id', '=', 'mahasiswa.id_guru_pamong')->where('guru_pamong.id_dpl', $id);

        if(request()->is_nilai == 'ada'){
            $dBMahasiswa->whereNotNull('nilai');
        }
        if(request()->is_nilai == 'tidak'){
            $dBMahasiswa->whereNull('nilai');
        }
        if(request()->filled('jenis_plp')){
            $dBMahasiswa->where('jenis_plp', request()->jenis_plp);
        }

        return $dBMahasiswa;
    }

    private function setQueryMahasiswa(){
        $dBMahasiswa = Mahasiswa::latest();

        if(request()->filled('nama')){
            $dBMahasiswa->where('nama', 'like', '%'.request()->nama.'%');
        }
        if(request()->filled('jenis_plp')){
            $dBMahasiswa->where('jenis_plp', request()->jenis_plp);
        }
        if(request()->filled('prodi')){
            $dBMahasiswa->where('prodi', request()->prodi);
        }
        if(request()->is_nilai == 'ada'){
            $dBMahasiswa->whereNotNull('nilai');
        }
        if(request()->is_nilai == 'tidak'){
            $dBMahasiswa->whereNull('nilai');
        }
        if(request()->filled('order_by_nama')){
            $dBMahasiswa->orderBy('nama', request()->order_by_nama);
        }

        return $dBMahasiswa;
    }

    private function getPertanyaanByNs(){
        try {
            $pertanyaan = Pertanyaan::where('jenis_kalimat', 'ns')->get();
        } catch (\Illuminate\Database\QueryException $e) {
            $pertanyaan = false;
        }
        return $pertanyaan;
    }

    private function getPertanyaanByPlpOne(){
        try {
            $pertanyaan = Pertanyaan::where('jenis_plp', 'plp_1')->get();
        } catch (\Illuminate\Database\QueryException $e) {
            $pertanyaan = false;
        }
        return $pertanyaan;
    }

    private function getPertanyaanByPlpTwo($jenisBidang, $jenisPertanyaan){
        try {
            $pertanyaan = Pertanyaan::where([
                ['jenis_plp', 'plp_2'],
                ['jenis_studi', $jenisBidang],
                ['jenis_kalimat', $jenisPertanyaan]
            ])->get();
        } catch (\Illuminate\Database\QueryException $e) {
            $pertanyaan = false;
        }
        return $pertanyaan;
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

    private function setNilai($credential, $id){
        $resultCredential = $this->setJenisNilai($credential);
        $resultCredential['total_nilai'] = $this->setTotalNilai($resultCredential, $id);
        
        return $resultCredential;
    }

    private function setTotalNilai($resultCredential, $id){
        $totalNilai = null;
        $nilaiKompeten = $this->getNilai($resultCredential, $id);
        if($resultCredential['jenis_bidang'] == 'bk' && ($resultCredential['jenis_plp'] == 'plp_2' || $resultCredential['jenis_plp'] == 'km_plp_2' || $resultCredential['jenis_plp'] == 'km_plp_2')){
            if($resultCredential['jenis_nilai'] == 'nilai_ne' && $nilaiKompeten['nilai_ne'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $resultCredential['nilai_ne'] + $nilaiKompeten['nilai_ns'] + $nilaiKompeten['nilai_nf'] + $nilaiKompeten['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nd' && $nilaiKompeten['nilai_nd'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $resultCredential['nilai_nd'] + $nilaiKompeten['nilai_ne'] + $nilaiKompeten['nilai_ns'] + $nilaiKompeten['nilai_nf'] + $nilaiKompeten['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nc' && $nilaiKompeten['nilai_nc'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $resultCredential['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne'] + $nilaiKompeten['nilai_ns'] + $nilaiKompeten['nilai_nf'] + $nilaiKompeten['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] == null){
                $totalNilai = ($resultCredential['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne'] + $nilaiKompeten['nilai_ns'] + $nilaiKompeten['nilai_nf'] + $nilaiKompeten['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_ns' && $nilaiKompeten['nilai_ns'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne'] + $resultCredential['nilai_ns'] + $nilaiKompeten['nilai_nf'] + $nilaiKompeten['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nf' && $nilaiKompeten['nilai_nf'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne'] + $nilaiKompeten['nilai_ns'] + $resultCredential['nilai_nf'] + $nilaiKompeten['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_ng' && $nilaiKompeten['nilai_ng'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne'] + $nilaiKompeten['nilai_ns'] + $nilaiKompeten['nilai_nf'] + $resultCredential['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_ne' && $nilaiKompeten['nilai_ne'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $resultCredential['nilai_ne'] + $nilaiKompeten['nilai_ns'] + $nilaiKompeten['nilai_nf'] + $nilaiKompeten['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nd' && $nilaiKompeten['nilai_nd'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $resultCredential['nilai_nd'] + $nilaiKompeten['nilai_ne'] + $nilaiKompeten['nilai_ns'] + $nilaiKompeten['nilai_nf'] + $nilaiKompeten['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nc' && $nilaiKompeten['nilai_nc'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $resultCredential['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne'] + $nilaiKompeten['nilai_ns'] + $nilaiKompeten['nilai_nf'] + $nilaiKompeten['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] != null){
                $totalNilai = ($resultCredential['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne'] + $nilaiKompeten['nilai_ns'] + $nilaiKompeten['nilai_nf'] + $nilaiKompeten['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_ns' && $nilaiKompeten['nilai_ns'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne'] + $resultCredential['nilai_ns'] + $nilaiKompeten['nilai_nf'] + $nilaiKompeten['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nf' && $nilaiKompeten['nilai_nf'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne'] + $nilaiKompeten['nilai_ns'] + $resultCredential['nilai_nf'] + $nilaiKompeten['nilai_ng']) / 7;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_ng' && $nilaiKompeten['nilai_ng'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ne'] + $nilaiKompeten['nilai_ns'] + $nilaiKompeten['nilai_nf'] + $resultCredential['nilai_ng']) / 7;
            }
        }
        else if($resultCredential['jenis_bidang'] == 'pgpaud' && ($resultCredential['jenis_plp'] == 'plp_2' || $resultCredential['jenis_plp'] == 'km_plp_2' || $resultCredential['jenis_plp'] == 'km_plp_2' || $resultCredential['jenis_plp'] == 'am_plp_2')){
            if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] == null){
                $totalNilai = ($resultCredential['nilai_nb'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ns']) / 3;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nd' && $nilaiKompeten['nilai_nd'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $resultCredential['nilai_nd'] + $nilaiKompeten['nilai_ns']) / 3;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_ns' && $nilaiKompeten['nilai_ns'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nd'] + $resultCredential['nilai_ns']) / 3;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] != null){
                $totalNilai = ($resultCredential['nilai_nb'] + $nilaiKompeten['nilai_nd'] + $nilaiKompeten['nilai_ns']) / 3;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nd' && $nilaiKompeten['nilai_nd'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $resultCredential['nilai_nd'] + $nilaiKompeten['nilai_ns']) / 3;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_ns' && $nilaiKompeten['nilai_ns'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nd'] + $resultCredential['nilai_ns']) / 3;
            }
        }
        else if($resultCredential['jenis_bidang'] == 'teaching' && ($resultCredential['jenis_plp'] == 'plp_2' || $resultCredential['jenis_plp'] == 'km_plp_2' || $resultCredential['jenis_plp'] == 'km_plp_2')){
            if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] == null){
                $totalNilai = ($resultCredential['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_ns']) / 3;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nc' && $nilaiKompeten['nilai_nc'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $resultCredential['nilai_nc'] + $nilaiKompeten['nilai_ns']) / 3;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_ns' && $nilaiKompeten['nilai_ns'] == null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $resultCredential['nilai_ns']) / 3;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] != null){
                $totalNilai = ($resultCredential['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $nilaiKompeten['nilai_ns']) / 3;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_nc' && $nilaiKompeten['nilai_nc'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $resultCredential['nilai_nc'] + $nilaiKompeten['nilai_ns']) / 3;
            }
            else if($resultCredential['jenis_nilai'] == 'nilai_ns' && $nilaiKompeten['nilai_ns'] != null){
                $totalNilai = ($nilaiKompeten['nilai_nb'] + $nilaiKompeten['nilai_nc'] + $resultCredential['nilai_ns']) / 3;
            }
        }
        else if($resultCredential['jenis_plp'] == 'plp_1' || $resultCredential['jenis_plp'] == 'km_plp_1'){
            if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] == null){
                $totalNilai = $resultCredential['nilai_nb'];
            }   
            else if($resultCredential['jenis_nilai'] == 'nilai_nb' && $nilaiKompeten['nilai_nb'] != null){
                $totalNilai = $resultCredential['nilai_nb'];
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

        if($credential['jenis_nilai'] == 'nilai_nb' && $credential['jenis_bidang'] == 'teaching' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNbTeaching($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nc' && $credential['jenis_bidang'] == 'teaching' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNcTeaching($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nd' && $credential['jenis_bidang'] == 'teaching' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNdTeaching($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_ns' && $credential['jenis_bidang'] == 'teaching' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNs($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nb' && $credential['jenis_bidang'] == 'bk' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNbBk($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nc' && $credential['jenis_bidang'] == 'bk' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNcBk($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nd' && $credential['jenis_bidang'] == 'bk' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNdBk($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_ne' && $credential['jenis_bidang'] == 'bk' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNeBk($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_ns' && $credential['jenis_bidang'] == 'bk' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNs($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nf' && $credential['jenis_bidang'] == 'bk' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNfBk($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_ng' && $credential['jenis_bidang'] == 'bk' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNgBk($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nb' && $credential['jenis_bidang'] == 'pgpaud' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNbPgpaud($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nd' && $credential['jenis_bidang'] == 'pgpaud' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNdPgpaud($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_ns' && $credential['jenis_bidang'] == 'pgpaud' && ($credential['jenis_plp'] == 'plp_2' || $credential['jenis_plp'] == 'km_plp_2' || $credential['jenis_plp'] == 'am_plp_2')){
            $credential[$jenisNilai] = $this->setNilaiNs($credential);
        }
        else if($credential['jenis_nilai'] == 'nilai_nb' && ($credential['jenis_plp'] == 'plp_1' || $credential['jenis_plp'] == 'km_plp_1')){
            $credential[$jenisNilai] = $this->setNilaiNbPlpOne($credential);
        }

        return $credential;
    }

    private function setNilaiNs($credential){
        $totalPoint = null;

        for ($i=0; $i < count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 24) * 100;
        
        return $hasil;
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

        for ($i=0; $i < count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 72) * 100;
        
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

    private function setNilaiNfBk($credential){
        $totalPoint = null;
        for($i=0; $i < count($credential['nilai_kompeten']); $i++){
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 28) * 100;

        return round($hasil, 2);
    }

    private function setNilaiNgBk($credential){
        $totalPoint = null;
        for($i=0; $i < count($credential['nilai_kompeten']); $i++){
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 24) * 100;

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

    private function setNilaiNbPlpOne($credential){
        $totalPoint = null;

        for ($i=0; $i < count($credential['nilai_kompeten']); $i++) { 
            $totalPoint = $totalPoint+$credential['nilai_kompeten'][$i];
        }

        $hasil = ($totalPoint / 40) * 100;

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
