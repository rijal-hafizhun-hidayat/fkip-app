<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Akun\AkunController;
use App\Http\Controllers\Akun\Service\AkunService;
use App\Http\Controllers\Akun\Service\AkunImportService;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Mahasiswa\Service\MahasiswaService;
use App\Http\Controllers\Mahasiswa\Service\MahasiswaImportService;
use App\Http\Controllers\Guru_Pamong\GuruPamongController;
use App\Http\Controllers\Guru_Pamong\Service\GuruPamongService;
use App\Http\Controllers\Guru_Pamong\Service\GuruPamongImportService;
use App\Http\Controllers\Dpl\DplController;
use App\Http\Controllers\Dpl\Service\DplService;
use App\Http\Controllers\Dpl\Service\DplImportService;
use App\Http\Controllers\Bimbingan\BimbinganController;
use App\Http\Controllers\Bimbingan\Service\BimbinganService;
use App\Http\Controllers\Sekolah\SekolahController;
use App\Http\Controllers\Sekolah\Service\SekolahService;
use App\Http\Controllers\Sekolah\Service\SekolahImportService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // //profile
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('isAdmin')->group(function (){

        //route akun
        Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
        Route::get('/akun/create', [AkunController::class, 'create'])->name('akun.create');
        Route::get('/akun/{id}', [AkunController::class, 'show'])->name('akun.show');
        Route::get('/akun/tambah-mahasiswa/{id}', [AkunController::class, 'addMhs'])->name('akun.addMhs');
        Route::get('/akun/reset-pass/{id}', [AkunController::class, 'formResetPass'])->name('akun.formResetPass');

        //service akun
        Route::get('/getAkuns', [AkunService::class, 'getAkuns'])->name('akun.getAkuns');
        Route::get('/getAkunById/{id}', [AkunService::class, 'getAkunById'])->name('akun.getAkunById');
        Route::post('/akun', [AkunService::class, 'store'])->name('akun.store');
        Route::delete('/akun/{id}', [AkunService::class, 'destroy'])->name('akun.destroy');
        Route::put('/akun/{id}', [AkunService::class, 'update'])->name('akun.update');
        Route::get('/getGuruPamongByIdGuruPamong/{id}', [AkunService::class, 'getGuruPamongByIdGuruPamong'])->name('akun.getGuruPamongByIdGuruPamong');
        Route::get('/getDplByIdDpl/{id}', [AkunService::class, 'getDplByIdDpl'])->name('akun.getDplByIdDpl');
        Route::get('/getMahasiswaByIdMahasiswa/{id}', [AkunService::class, 'getMahasiswaByIdMahasiswa'])->name('akun.getMahasiswaByIdMahasiswa');
        Route::put('/destroyAsosiasiGuruPamong/{id}', [AkunService::class, 'destroyAsosiasiGuruPamong'])->name('akun.destroyAsosiasiGuruPamong');
        Route::put('/destroyAsosiasiDpl/{id}', [AkunService::class, 'destroyAsosiasiDpl'])->name('akun.destroyAsosiasiDpl');
        Route::put('/resetPass/{id}', [AkunService::class, 'resetPass'])->name('akun.resetPass');
        Route::get('/getProdi/{prodi}', [AkunService::class, 'getProdi'])->name('akun.getProdi');
        Route::post('/akun/import/dpl', [AkunImportService::class, 'importAkunDpl'])->name('akun.importAkunDpl');
        Route::post('/akun/import/guru-pamong', [AkunImportService::class, 'importAkunGuruPamong'])->name('akun.importAkunGuruPamong');
        Route::post('/akun/import/mahasiswa', [AkunImportService::class, 'importAkunMahasiswa'])->name('akun.importAkunMahasiswa');

        //route dpl
        Route::get('/dpl', [DplController::class, 'index'])->name('dpl.index');
        Route::get('/dpl/create', [DplController::class, 'create'])->name('dpl.create');
        Route::get('/dpl/{id}', [DplController::class, 'show'])->name('dpl.show');
        Route::get('/dpl/asosiasi/{id}', [DplController::class, 'dplGuruPamongMahasiswa'])->name('dpl.dplGuruPamongMahasiswa');

        //service dpl
        Route::get('/getDpls', [DplService::class, 'getDpls'])->name('dpl.getDpls');
        Route::get('/getDplById/{id}', [DplService::class, 'getDplById'])->name('dpl.getDplById');
        Route::get('/getDplGuruPamongById/{id}', [DplService::class, 'getDplGuruPamongById'])->name('dpl.getDplGuruPamongById');
        Route::post('/dpl', [DplService::class, 'store'])->name('dpl.store');
        Route::delete('/dpl/{id}', [DplService::class, 'destroy'])->name('dpl.destroy');
        Route::put('/dpl/{id}', [DplService::class, 'update'])->name('dpl.update');
        Route::post('/dpl/import', [DplImportService::class, 'import'])->name('dpl.import');
        Route::put('/storeGuruPamong/{id}', [DplService::class, 'storeGuruPamong'])->name('dpl.storeGuruPamong');
        Route::put('/destroyAssociationGuruPamong/{id}', [DplService::class, 'destroyAssociationGuruPamong'])->name('dpl.destroyAssociationGuruPamong');
        Route::get('/getDplByProdi/{prodi}', [DplService::class, 'getDplByProdi'])->name('guru_pamong.getDplByProdi');
    });

    //route mahasiswa
    Route::middleware('isAdminDplGuruPamong')->group(function(){
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/mahasiswa/nilai/{jenisPlp}/{prodi}/{id}', [MahasiswaController::class, 'nilai'])->name('mahasiswa.nilai');

        Route::middleware('isAdmin')->group(function(){
            Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
            Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
            Route::get('/mahasiswa/dpl/{id}', [MahasiswaController::class, 'addAsosiasiDpl'])->name('mahasiswa.addAsosiasiDpl');
            Route::get('/mahasiswa/asosiasi/{id}', [MahasiswaController::class, 'asosiasiMahasiswa'])->name('mahasiswa.asosiasiMahasiswa');

            //service mahasiswa
            Route::get('/getMahasiswa', [MahasiswaService::class, 'getMahasiswa'])->name('mahasiswa.getMahasiswa');
            Route::get('/getMahasiswaNoPaginate', [MahasiswaService::class, 'getMahasiswaNoPaginate'])->name('mahasiswa.getMahasiswaNoPaginate');
            Route::post('/mahasiswa', [MahasiswaService::class, 'store'])->name('mahasiswa.store');
            Route::delete('/mahasiswa/{id}', [MahasiswaService::class, 'destroy'])->name('mahasiswa.destroy');
            Route::put('/mahasiswa/{id}', [MahasiswaService::class, 'update'])->name('mahasiswa.update');
            Route::post('/mahasiswa/import', [MahasiswaImportService::class, 'import'])->name('mahasiswa.import');
            Route::put('/updateIdDpl/{id}', [MahasiswaService::class, 'updateIdDpl'])->name('mahasiswa.updateIdDpl');
            Route::delete('/destroyAsosiasiDpl/{id}', [MahasiswaService::class, 'destroyAsosiasiDpl'])->name('mahasiswa.destroyAsosiasiDpl');
            Route::get('/getDplMahasiswaById/{id}', [MahasiswaService::class, 'getDplMahasiswaById'])->name('mahasiswa.getDplMahasiswaById');
        });
        Route::get('/getMahasiswaBimbinganByIdDpl/{id}', [MahasiswaService::class, 'getMahasiswaBimbinganByIdDpl'])->name('mahasiswa.getMahasiswaBimbinganByIdDpl');
        Route::get('/getMahasiswaByIdDpl/{id}', [MahasiswaService::class, 'getMahasiswaByIdDpl'])->name('mahasiswa.getMahasiswaByIdDpl');
        Route::get('/getNilaiKomponenByIdMahasiswa/{jenis_plp}/{id}', [MahasiswaService::class, 'getNilaiKomponenByIdMahasiswa'])->name('mahasiswa.getNilaiKomponenByIdMahasiswa');
        Route::get('/getMahasiswaByIdAkun/{id}', [MahasiswaService::class, 'getMahasiswaByIdAkun'])->name('mahasiswa.getMahasiswaByIdAkun')->middleware('isGuruPamong');
        Route::put('/updateNilai/{id}', [MahasiswaService::class, 'updateNilai'])->name('mahasiswa.updateNilai');
        Route::get('/getPertanyaanByJenisPlpJenisBidangJenisPertanyaan/{jenisPlp}/{jenisBidang}/{jenisPertanyaan}', [MahasiswaService::class, 'getPertanyaanByJenisPlpJenisBidangJenisPertanyaan'])->name('mahasiswa.getPertanyaanByJenisPlpJenisBidangJenisPertanyaan');
    });
    
    Route::get('/getMahasiswaById/{id}', [MahasiswaService::class, 'getMahasiswaById'])->name('mahasiswa.getMahasiswaById');
    //Route::get('/getNilaiMahasiswaByIdMahasiswa/{id}', [MahasiswaService::class, 'getNilaiMahasiswaByIdMahasiswa'])->name('mahasiswa.getNilaiMahasiswaByIdMahasiswa');
    Route::get('/getMahasiswaNilaiById/{id}', [MahasiswaService::class, 'getMahasiswaNilaiById'])->name('mahasiswa.getMahasiswaNilaiById');

    //route guru pamong
    Route::middleware('isAdminDpl')->group(function(){

        Route::get('/guru-pamong', [GuruPamongController::class, 'index'])->name('guru_pamong.index');
        Route::get('/guru-pamong/mahasiswa/{id}', [GuruPamongController::class, 'createAsosiasiMahasiswa'])->name('guru_pamong.addAsosiasiMahasiswa');
        Route::get('/guru-pamong/mahasiswa/nilai/{id}', [GuruPamongController::class, 'showNilaiMahasiswa'])->name('guru_pamong.showNilaiMahasiswa');

        Route::middleware('isAdmin')->group(function(){
            Route::get('/guru-pamong/create', [GuruPamongController::class, 'create'])->name('guru_pamong.create');
            Route::get('/guru-pamong/{id}', [GuruPamongController::class, 'show'])->name('guru_pamong.show');

            //service guru pamong
            Route::get('/getGuruPamongs', [GuruPamongService::class, 'getGuruPamongs'])->name('guru_pamong.getGuruPamongs');
            Route::post('/guru-pamong', [GuruPamongService::class, 'store'])->name('guru_pamong.store');
            Route::put('/guru-pamong/{id}', [GuruPamongService::class, 'update'])->name('guru_pamong.update');
            Route::delete('/guru-pamong/{id}', [GuruPamongService::class, 'destroy'])->name('guru_pamong.destroy');
            Route::post('/guru-pamong/import', [GuruPamongImportService::class, 'import'])->name('guru_pamong.import');
            Route::put('/guru-pamong/import/asosiasi', [GuruPamongImportService::class, 'importAsosiasiMahasiswa'])->name('guru_pamong.importAsosiasiMahasiswa');
            Route::put('/storeAsosiasiMahasiswa/{id}', [GuruPamongService::class, 'storeAsosiasiMahasiswa'])->name('guru_pamong.storeAsosiasiMahasiswa');
            Route::put('/destroyAsosiasiMahasiswa/{id}', [GuruPamongService::class, 'destroyAsosiasiMahasiswa'])->name('guru_pamong.destroyAsosiasiMahasiswa');
            Route::get('/getBidangKeahlian', [GuruPamongService::class, 'getBidangKeahlian'])->name('guru_pamong.getBidangKeahlian');
        });
        
        Route::get('/getGuruPamongById/{id}', [GuruPamongService::class, 'getGuruPamongById'])->name('guru_pamong.getGuruPamongById');
        Route::get('/getGuruPamongByIdDpl/{id}', [GuruPamongService::class, 'getGuruPamongByIdDpl'])->name('guru_pamong.getGuruPamongByIdDpl');
        Route::get('/getMahasiswaByIdGuruPamong/{id}', [GuruPamongService::class, 'getMahasiswaByIdGuruPamong'])->name('guru_pamong.getMahasiswaByIdGuruPamong');
        Route::get('/getMahasiswaIsNull', [GuruPamongService::class, 'getMahasiswaIsNull'])->name('guru_pamong.getMahasiswaIsNull');
    });

    //route bimbingan
    Route::middleware('isAdminDplMahasiswa')->group(function(){
        Route::get('/bimbingans/{id}', [BimbinganController::class, 'index'])->name('bimbingan.index');
        Route::get('/bimbingan/create/{id}', [BimbinganController::class, 'create'])->name('bimbingan.create');

        //service
        Route::middleware('isDpl')->group(function(){
            Route::put('/bimbingan/catatan-pemimbing/{id}', [BimbinganService::class, 'storeCatatanPembimbing'])->name('bimbingan.storeCatatanPembimbing');
            Route::put('/bimbingan/confirmed/{id}', [BimbinganService::class, 'confirmed'])->name('bimbingan.confirmed');
        });
        Route::delete('/bimbingan/{id}', [BimbinganService::class, 'destroy'])->name('bimbingan.destroy');
        Route::put('/bimbingan/{id}', [BimbinganService::class, 'update'])->name('bimbingan.update');
        Route::get('/bimbingan/{id}', [BimbinganService::class, 'getBimbinganById'])->name('bimbingan.getBimbinganById');
        Route::get('/getBimbinganByIdMahasiswa/{id}', [BimbinganService::class, 'getBimbinganByIdMahasiswa'])->name('bimbingan.getBimbinganByIdMahasiswa');
        Route::post('/bimbingan/{id}', [BimbinganService::class, 'store'])->name('bimbingan.store');
    });

    //router sekolah
    Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
    Route::get('/sekolah/create', [SekolahController::class, 'create'])->name('sekolah.create');
    Route::get('/sekolah/{id}', [SekolahController::class, 'show'])->name('sekolah.show');

    //service sekolah
    Route::get('/getSekolah', [SekolahService::class, 'getSekolah'])->name('sekolah.getSekolah');
    Route::post('/sekolah', [SekolahService::class, 'store'])->name('sekolah.store');
    Route::get('/getSekolahById/{id}', [SekolahService::class, 'getSekolahById'])->name('sekolah.getSekolahById');
    Route::put('/sekolah/{id}', [SekolahService::class, 'update'])->name('sekolah.update');
    Route::delete('/sekolah/{id}', [SekolahService::class, 'destroy'])->name('sekolah.destroy');
    Route::post('/sekolah/import', [SekolahImportService::class, 'import'])->name('sekolah.import');

    //service all role
    Route::get('/getDpl', [DplService::class, 'getDpl'])->name('dpl.getDpl');
    Route::get('/getGuruPamongsIsNull', [DplService::class, 'getGuruPamongsIsNull'])->name('dpl.getGuruPamongsIsNull');
    Route::get('/getGuruPamongByIdMahasiswa/{id}', [GuruPamongService::class, 'getGuruPamongByIdMahasiswa'])->name('guru_pamong.getGuruPamongByIdMahasiswa');
    Route::get('/getDplByIdMahasiswa/{id}', [DplService::class, 'getDplByIdMahasiswa'])->name('dpl.getDplByIdMahasiswa');
});

require __DIR__.'/auth.php';
