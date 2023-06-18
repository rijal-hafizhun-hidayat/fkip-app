<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Akun\AkunController;
use App\Http\Controllers\Akun\Service\AkunService;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Mahasiswa\Service\MahasiswaService;
use App\Http\Controllers\Mahasiswa\Service\MahasiswaImportService;
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
    Route::get('/akuns', [AkunController::class, 'index'])->name('akun');
    Route::get('/akuns/create', [AkunController::class, 'create'])->name('akun.create');
    Route::get('/akun/{id}', [AkunController::class, 'show'])->name('akun.show');
    Route::get('/akun/tambah-mahasiswa/{id}', [AkunController::class, 'addMhs'])->name('akun.addMhs');

    //service akun
    Route::get('/getAkuns', [AkunService::class, 'getAkuns'])->name('akun.getAkuns');
    Route::get('/getAkunById/{id}', [AkunService::class, 'getAkunById'])->name('akun.getAkunById');
    Route::post('/akuns', [AkunService::class, 'store'])->name('akun.store');
    Route::delete('/akuns/{id}', [AkunService::class, 'destroy'])->name('akun.destroy');
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
});

require __DIR__.'/auth.php';
