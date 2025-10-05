<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenProfileController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\PublicPresensiController;

Route::get('/', function () {
    return redirect()->route('public.presensi.index');
});

// Public Presensi Routes (Tidak perlu login) - HARUS DIDAHULUKAN
Route::get('/presensi', [PublicPresensiController::class, 'index'])->name('public.presensi.index');
Route::post('/presensi/submit', [PublicPresensiController::class, 'submit'])->name('public.presensi.submit');
Route::get('/presensi/info', [PublicPresensiController::class, 'getPresensiInfo'])->name('public.presensi.info');
Route::get('/presensi/display/{kode}', [PublicPresensiController::class, 'display'])->name('public.presensi.display');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.post');

// Admin Routes (Super Admin only)
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('dosen', DosenController::class);
    Route::resource('unit', UnitController::class);
    Route::get('/unit/ajax/fakultas', [UnitController::class, 'getFakultas'])->name('unit.fakultas');
    
    // Mahasiswa Import Routes (superadmin only)
    Route::get('/mahasiswa/import/form', [MahasiswaController::class, 'importForm'])->name('mahasiswa.import.form');
    Route::post('/mahasiswa/import', [MahasiswaController::class, 'import'])->name('mahasiswa.import');
    Route::get('/mahasiswa/template/download', [MahasiswaController::class, 'downloadTemplate'])->name('mahasiswa.template.download');
});

// Mahasiswa Routes for Both Roles (Shared)
Route::middleware(['auth'])->group(function () {
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::get('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::get('/mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::put('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
    Route::get('/mahasiswa/ajax/prodis', [MahasiswaController::class, 'getProdisByFakultas'])->name('mahasiswa.ajax.prodis');
});

// Presensi Routes for Both Roles (Shared) - dengan prefix admin/presensi
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('presensi', PresensiController::class);
    Route::post('/presensi/{presensi}/toggle-status', [PresensiController::class, 'toggleStatus'])->name('presensi.toggle-status');
    Route::get('/presensi-ajax/prodi-options', [PresensiController::class, 'getProdiOptions'])->name('admin.presensi.get-prodi');
    Route::get('/presensi-ajax/kelas-by-prodi', [PresensiController::class, 'getKelasByProdi'])->name('admin.presensi.get-kelas');
});

// Dosen Routes
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dosenDashboard'])->name('dosen.dashboard');
    
    // Profile Routes
    Route::get('/profile', [DosenProfileController::class, 'show'])->name('dosen.profile.show');
    Route::get('/profile/edit', [DosenProfileController::class, 'edit'])->name('dosen.profile.edit');
    Route::put('/profile', [DosenProfileController::class, 'update'])->name('dosen.profile.update');
});
