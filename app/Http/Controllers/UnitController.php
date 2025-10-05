<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::with('parent')->latest()->get();
        return view('admin.unit.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fakultas = Unit::fakultas()->active()->orderBy('name')->get();
        return view('admin.unit.create', compact('fakultas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'required|in:fakultas,program_studi',
            'code' => 'nullable|string|max:50|unique:units,code',
            'description' => 'nullable|string',
        ];

        // Jika type adalah program_studi, parent_id wajib diisi
        if ($request->type === 'program_studi') {
            $rules['parent_id'] = 'required|exists:units,id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = [
                'name' => $request->name,
                'type' => $request->type,
                'code' => $request->code,
                'description' => $request->description,
                'is_active' => $request->has('is_active')
            ];

            // Set parent_id hanya jika type adalah program_studi
            if ($request->type === 'program_studi') {
                $data['parent_id'] = $request->parent_id;
            }

            Unit::create($data);

            return redirect()->route('unit.index')
                ->with('success', 'Unit berhasil ditambahkan!');
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
        $unit = Unit::with(['parent', 'children'])->findOrFail($id);
        return view('admin.unit.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unit = Unit::with('parent')->findOrFail($id);
        $fakultas = Unit::fakultas()->active()->orderBy('name')->get();
        return view('admin.unit.edit', compact('unit', 'fakultas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = Unit::findOrFail($id);
        
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'required|in:fakultas,program_studi',
            'code' => 'nullable|string|max:50|unique:units,code,' . $id,
            'description' => 'nullable|string',
        ];

        // Jika type adalah program_studi, parent_id wajib diisi
        if ($request->type === 'program_studi') {
            $rules['parent_id'] = 'required|exists:units,id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = [
                'name' => $request->name,
                'type' => $request->type,
                'code' => $request->code,
                'description' => $request->description,
                'is_active' => $request->has('is_active')
            ];

            // Set parent_id hanya jika type adalah program_studi
            if ($request->type === 'program_studi') {
                $data['parent_id'] = $request->parent_id;
            } else {
                $data['parent_id'] = null; // Reset parent jika diubah ke fakultas
            }

            $unit->update($data);

            return redirect()->route('unit.index')
                ->with('success', 'Unit berhasil diperbarui!');
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
            $unit = Unit::findOrFail($id);

            // Cek apakah unit memiliki children (program studi)
            if ($unit->children()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus unit yang memiliki program studi.'
                ], 400);
            }

            $unit->delete();

            return response()->json([
                'success' => true,
                'message' => 'Unit berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get fakultas untuk AJAX request
     */
    public function getFakultas()
    {
        $fakultas = Unit::fakultas()->active()->orderBy('name')->get(['id', 'name']);
        return response()->json($fakultas);
    }
}
