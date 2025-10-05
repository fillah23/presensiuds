<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba login dengan guard web (users table)
        if (Auth::guard('web')->attempt([
            'email' => $request->email, 
            'password' => $request->password,
            'is_active' => true
        ])) {
            $user = Auth::user();
            
            if ($user->role) {
                if ($user->role->name === 'superadmin') {
                    return redirect()->route('dashboard')->with('success', 'Berhasil login sebagai Super Admin!');
                } elseif ($user->role->name === 'dosen') {
                    return redirect()->route('presensi.index')->with('success', 'Berhasil login sebagai Dosen!');
                }
            }
            
            // Jika tidak ada role yang sesuai
            Auth::logout();
            return back()->withErrors(['email' => 'Role tidak valid.']);
        }

        return back()->withErrors(['email' => 'Email atau password salah, atau akun tidak aktif.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}
