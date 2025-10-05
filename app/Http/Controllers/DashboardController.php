<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        
        return view('admin.dashboard', compact('totalDosen', 'dosenAktif', 'dosenNonAktif'));
    }

    public function dosenDashboard()
    {
        // Dashboard untuk Dosen
        $user = Auth::user();
        
        return view('dosen.dashboard', compact('user'));
    }
}
