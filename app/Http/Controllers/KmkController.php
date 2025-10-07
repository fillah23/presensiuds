<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KmkController extends Controller
{
    /**
     * Check if user is dosen or superadmin
     */
    private function checkAccess()
    {
        $user = Auth::user();
        if (!$user || !$user->role || 
            ($user->role->name !== 'dosen' && $user->role->name !== 'superadmin')) {
            abort(403, 'Unauthorized - Hanya dosen dan superadmin yang dapat mengakses halaman ini');
        }
        return $user;
    }

    /**
     * Check if KMK belongs to current dosen (for dosen only)
     */
    private function checkKmkOwnership(User $kmk)
    {
        $user = $this->checkAccess();
        
        // Superadmin bisa akses semua KMK
        if ($user->role->name === 'superadmin') {
            return $user;
        }
        
        // Dosen hanya bisa akses KMK miliknya
        if ($user->role->name === 'dosen' && $kmk->parent_dosen_id !== Auth::id()) {
            abort(403, 'Unauthorized - KMK ini bukan milik Anda');
        }
        
        return $user;
    }

    /**
     * Display a listing of KMK users
     */
    public function index()
    {
        $user = $this->checkAccess();

        if ($user->role->name === 'superadmin') {
            // Superadmin bisa lihat semua KMK
            $kmkUsers = User::with(['role', 'parentDosen'])
                ->whereHas('role', function($query) {
                    $query->where('name', 'kmk');
                })
                ->get();
        } else {
            // Dosen hanya bisa lihat KMK miliknya
            $kmkUsers = User::with('role')
                ->where('parent_dosen_id', Auth::id())
                ->get();
        }

        return view('kmk.index', compact('kmkUsers'));
    }

    /**
     * Show the form for creating a new KMK
     */
    public function create()
    {
        $user = $this->checkAccess();
        
        // Ambil daftar dosen untuk superadmin
        $dosens = null;
        if ($user->role->name === 'superadmin') {
            $dosens = User::whereHas('role', function($query) {
                $query->where('name', 'dosen');
            })->where('is_active', true)->get();
        }

        return view('kmk.create', compact('dosens'));
    }

    /**
     * Store a newly created KMK
     */
    public function store(Request $request)
    {
        $user = $this->checkAccess();

        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nomor_whatsapp' => 'nullable|string|max:20',
        ];

        // Jika superadmin, tambahkan validasi untuk parent_dosen_id
        if ($user->role->name === 'superadmin') {
            $validationRules['parent_dosen_id'] = 'required|exists:users,id';
        }

        $request->validate($validationRules);

        $kmkRole = Role::where('name', 'kmk')->first();

        // Tentukan parent_dosen_id
        $parentDosenId = $user->role->name === 'superadmin' 
            ? $request->parent_dosen_id 
            : Auth::id();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $kmkRole->id,
            'parent_dosen_id' => $parentDosenId,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'is_active' => true,
        ]);

        $redirectRoute = Auth::user()->role->name === 'superadmin' ? 'admin.kmk.index' : 'kmk.index';
        
        return redirect()->route($redirectRoute)
            ->with('success', 'KMK berhasil ditambahkan');
    }

    /**
     * Display the specified KMK
     */
    public function show(User $kmk)
    {
        $this->checkKmkOwnership($kmk);

        return view('kmk.show', compact('kmk'));
    }

    /**
     * Show the form for editing the specified KMK
     */
    public function edit(User $kmk)
    {
        $user = $this->checkKmkOwnership($kmk);

        // Ambil daftar dosen untuk superadmin
        $dosens = null;
        if ($user->role->name === 'superadmin') {
            $dosens = User::whereHas('role', function($query) {
                $query->where('name', 'dosen');
            })->where('is_active', true)->get();
        }

        return view('kmk.edit', compact('kmk', 'dosens'));
    }

    /**
     * Update the specified KMK
     */
    public function update(Request $request, User $kmk)
    {
        $user = $this->checkKmkOwnership($kmk);

        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $kmk->id,
            'password' => 'nullable|string|min:8|confirmed',
            'nomor_whatsapp' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ];

        // Jika superadmin, tambahkan validasi untuk parent_dosen_id
        if ($user->role->name === 'superadmin') {
            $validationRules['parent_dosen_id'] = 'required|exists:users,id';
        }

        $request->validate($validationRules);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'is_active' => $request->has('is_active'),
        ];

        // Jika superadmin, update parent_dosen_id
        if ($user->role->name === 'superadmin') {
            $updateData['parent_dosen_id'] = $request->parent_dosen_id;
        }

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $kmk->update($updateData);

        $redirectRoute = Auth::user()->role->name === 'superadmin' ? 'admin.kmk.index' : 'kmk.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'KMK berhasil diperbarui');
    }

    /**
     * Remove the specified KMK
     */
    public function destroy(User $kmk)
    {
        $this->checkKmkOwnership($kmk);

        $kmk->delete();

        $redirectRoute = Auth::user()->role->name === 'superadmin' ? 'admin.kmk.index' : 'kmk.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'KMK berhasil dihapus');
    }
}
