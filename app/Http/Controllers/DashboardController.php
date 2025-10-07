<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Unit;
use App\Models\Mahasiswa;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard untuk Super Admin
        $totalDosen = User::whereHas('role', function($query) {
            $query->where('name', 'dosen');
        })->count();
        
        $dosenAktif = User::whereHas('role', function($query) {
            $query->where('name', 'dosen');
        })->where('is_active', true)->count();
        
        $dosenNonAktif = User::whereHas('role', function($query) {
            $query->where('name', 'dosen');
        })->where('is_active', false)->count();
        
        // Data tambahan untuk dashboard yang lebih lengkap
        $totalFakultas = Unit::where('type', 'fakultas')->count();
        $totalProdi = Unit::where('type', 'program_studi')->count();
        $totalMahasiswa = Mahasiswa::count();
        
        // Presensi hari ini
        $presensiHariIni = Presensi::whereDate('waktu_mulai', Carbon::today())->count();
        
        return view('admin.dashboard', compact(
            'totalDosen', 'dosenAktif', 'dosenNonAktif',
            'totalFakultas', 'totalProdi', 'totalMahasiswa', 'presensiHariIni'
        ));
    }

    public function dosenDashboard()
    {
        // Dashboard untuk Dosen
        $user = Auth::user();
        
        return view('dosen.dashboard', compact('user'));
    }

    public function kmkDashboard()
    {
        // Dashboard untuk KMK
        $user = Auth::user();
        $dosenId = $user->getPresensiDosenId();
        
        // Statistik presensi yang dikelola KMK
        $totalPresensi = Presensi::where('dosen_id', $dosenId)->count();
        $presensiAktif = Presensi::where('dosen_id', $dosenId)->where('is_active', true)->count();
        $presensiHariIni = Presensi::where('dosen_id', $dosenId)
            ->whereDate('waktu_mulai', Carbon::today())
            ->count();
        
        return view('kmk.dashboard', compact('user', 'totalPresensi', 'presensiAktif', 'presensiHariIni'));
    }
}
