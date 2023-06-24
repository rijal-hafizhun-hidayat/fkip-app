<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Akun\AkunController;
use App\Http\Controllers\Akun\Service\AkunService;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Mahasiswa\Service\MahasiswaService;
use App\Http\Controllers\Mahasiswa\Service\MahasiswaImportService;
use App\Http\Controllers\Guru_Pamong\GuruPamongController;
use App\Http\Controllers\Guru_Pamong\Service\GuruPamongService;
use App\Http\Controllers\Guru_Pamong\Service\GuruPamongImportService;
use App\Http\Controllers\Dpl\DplController;
use App\Http\Controllers\Dpl\Service\DplService;
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

    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //akun
    Route::get('/akun', [AkunController::class, 'index'])->name('akun');
    Route::get('/akun/create', [AkunController::class, 'create'])->name('akun.create');
    Route::get('/akun/{id}', [AkunController::class, 'show'])->name('akun.show');
    Route::get('/akun/tambah-mahasiswa/{id}', [AkunController::class, 'addMhs'])->name('akun.addMhs');

    //service akun
    Route::get('/getAkuns', [AkunService::class, 'getAkuns'])->name('akun.getAkuns');
    Route::get('/getAkunById/{id}', [AkunService::class, 'getAkunById'])->name('akun.getAkunById');
    Route::post('/akun', [AkunService::class, 'store'])->name('akun.store');
    Route::delete('/akun/{id}', [AkunService::class, 'destroy'])->name('akun.destroy');
    Route::put('/akun/{id}', [AkunService::class, 'update'])->name('akun.update');

    //mahasiswa
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa');
    Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');

    //service mahasiswa
    Route::get('/getMahasiswa', [MahasiswaService::class, 'getMahasiswa'])->name('mahasiswa.getMahasiswa');
    Route::get('/getMahasiswaById/{id}', [MahasiswaService::class, 'getMahasiswaById'])->name('mahasiswa.getMahasiswaById');
    Route::post('/mahasiswa', [MahasiswaService::class, 'store'])->name('mahasiswa.store');
    Route::delete('/mahasiswa/{id}', [MahasiswaService::class, 'destroy'])->name('mahasiswa.destroy');
    Route::put('/mahasiswa/{id}', [MahasiswaService::class, 'update'])->name('mahasiswa.update');
    Route::post('/mahasiswa/import', [MahasiswaImportService::class, 'import'])->name('mahasiswa.import');

    //guru pamong
    Route::get('/guru-pamong', [GuruPamongController::class, 'index'])->name('guru_pamong');
    Route::get('/guru-pamong/create', [GuruPamongController::class, 'create'])->name('guru_pamong.create');
    Route::get('/guru-pamong/{id}', [GuruPamongController::class, 'show'])->name('guru_pamong.show');

    //service guru pamong
    Route::get('/getGuruPamongs', [GuruPamongService::class, 'getGuruPamongs'])->name('guru_pamong.getGuruPamongs');
    Route::post('/guru-pamong', [GuruPamongService::class, 'store'])->name('guru_pamong.store');
    Route::get('/getGuruPamongById/{id}', [GuruPamongService::class, 'getGuruPamongById'])->name('guru_pamong.getGuruPamongById');
    Route::put('/guru-pamong/{id}', [GuruPamongService::class, 'update'])->name('guru_pamong.update');
    Route::delete('/guru-pamong/{id}', [GuruPamongService::class, 'destroy'])->name('guru_pamong.destroy');
    Route::post('/guru-pamong/import', [GuruPamongImportService::class, 'import'])->name('guru_pamong.import');

    //dpl
    Route::get('/dpl', [DplController::class, 'index'])->name('dpl');
    Route::get('/dpl/create', [DplController::class, 'create'])->name('dpl.create');
    Route::get('/dpl/{id}', [DplController::class, 'show'])->name('dpl.show');

    //service dpl
    Route::get('/getDpls', [DplService::class, 'getDpls'])->name('dpl.getDpls');
    Route::get('/getDplById/{id}', [DplService::class, 'getDplById'])->name('dpl.getDplById');
    Route::post('/dpl', [DplService::class, 'store'])->name('dpl.store');
    Route::delete('/dpl/{id}', [DplService::class, 'destroy'])->name('dpl.destroy');
    Route::put('/dpl/{id}', [DplService::class, 'update'])->name('dpl.update');
});

require __DIR__.'/auth.php';
