<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dosens = User::with('role')->whereHas('role', function($query) {
            $query->where('name', 'dosen');
        })->latest()->get();
        
        return view('admin.dosen.index', compact('dosens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dosen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nuptk' => 'required|string|unique:users,nuptk|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'nomor_whatsapp' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Dapatkan role dosen
            $dosenRole = Role::where('name', 'dosen')->first();
            
            if (!$dosenRole) {
                return redirect()->back()
                    ->with('error', 'Role dosen tidak ditemukan!')
                    ->withInput();
            }

            User::create([
                'name' => $request->name,
                'nuptk' => $request->nuptk,
                'email' => $request->email,
                'nomor_whatsapp' => $request->nomor_whatsapp,
                'password' => Hash::make($request->password),
                'role_id' => $dosenRole->id,
                'is_active' => true
            ]);

            return redirect()->route('dosen.index')
                ->with('success', 'Data dosen berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dosen = User::with('role')->whereHas('role', function($query) {
            $query->where('name', 'dosen');
        })->findOrFail($id);
        
        return view('admin.dosen.show', compact('dosen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dosen = User::with('role')->whereHas('role', function($query) {
            $query->where('name', 'dosen');
        })->findOrFail($id);
        
        return view('admin.dosen.edit', compact('dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dosen = User::whereHas('role', function($query) {
            $query->where('name', 'dosen');
        })->findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nuptk' => 'required|string|max:255|unique:users,nuptk,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'nomor_whatsapp' => 'required|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = [
                'name' => $request->name,
                'nuptk' => $request->nuptk,
                'email' => $request->email,
                'nomor_whatsapp' => $request->nomor_whatsapp,
                'is_active' => $request->has('is_active')
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $dosen->update($data);

            return redirect()->route('dosen.index')
                ->with('success', 'Data dosen berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $dosen = User::whereHas('role', function($query) {
                $query->where('name', 'dosen');
            })->findOrFail($id);
            
            $dosen->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data dosen berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
