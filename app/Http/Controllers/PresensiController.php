<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\PresensiMahasiswa;
use App\Models\Unit;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presensis = Presensi::with('dosen')
            ->where('dosen_id', Auth::id())
            ->orderBy('waktu_mulai', 'desc')
            ->paginate(10);

        return view('admin.presensi.index', compact('presensis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::where('parent_id', '!=', null)->get(); // Hanya program studi
        
        return view('admin.presensi.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'resume_kelas' => 'required|string',
            'waktu_mulai' => 'required|date|after:now',
            'durasi_menit' => 'required|integer|min:5|max:180',
            'batas_terlambat' => 'required|integer|min:1|max:60', // 1-60 menit
            'prodi' => 'required|array|min:1',
            'prodi.*' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!\App\Models\Unit::where('type', 'program_studi')->where('name', $value)->exists()) {
                    $fail('Program studi yang dipilih tidak valid.');
                }
            }],
            'kelas' => 'required|array|min:1',
            'kelas.*' => 'required|string'
        ]);

        $presensi = Presensi::create([
            'nama_kelas' => $request->nama_kelas,
            'resume_kelas' => $request->resume_kelas,
            'waktu_mulai' => $request->waktu_mulai,
            'durasi_menit' => (int)$request->durasi_menit,
            'batas_terlambat' => (int)$request->batas_terlambat, // Tambah field
            'prodi' => $request->prodi,
            'kelas' => $request->kelas, // Save as JSON array
            'dosen_id' => Auth::id(),
            'is_active' => true
        ]);

        return redirect()->route('presensi.index')
            ->with('success', 'Presensi berhasil dibuat dengan kode: ' . $presensi->kode_presensi);
    }

    /**
     * Display the specified resource.
     */
    public function show(Presensi $presensi)
    {
        // Pastikan hanya dosen yang membuat presensi yang bisa melihat
        if ($presensi->dosen_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $presensi->load(['presensiMahasiswas', 'dosen']);
        
        // Get total mahasiswa berdasarkan multiple prodi dan kelas
        $totalMahasiswaQuery = Mahasiswa::whereHas('prodi', function($query) use ($presensi) {
            if (is_array($presensi->prodi)) {
                $query->whereIn('name', $presensi->prodi);
            } else {
                $query->where('name', $presensi->prodi);
            }
        });

        // Filter berdasarkan kelas jika ada
        if (!empty($presensi->kelas) && is_array($presensi->kelas)) {
            $totalMahasiswaQuery->whereIn('kelas', $presensi->kelas);
        }

        $totalMahasiswa = $totalMahasiswaQuery->count();

        return view('admin.presensi.show', compact('presensi', 'totalMahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presensi $presensi)
    {
        // Pastikan hanya dosen yang membuat presensi yang bisa edit
        if ($presensi->dosen_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Tidak bisa edit jika presensi sudah dimulai
        if (Carbon::now()->gte($presensi->waktu_mulai)) {
            return redirect()->route('presensi.show', $presensi)
                ->with('error', 'Presensi yang sudah dimulai tidak dapat diedit');
        }

        $units = Unit::where('parent_id', '!=', null)->get();
        
        return view('admin.presensi.edit', compact('presensi', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presensi $presensi)
    {
        // Pastikan hanya dosen yang membuat presensi yang bisa update
        if ($presensi->dosen_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Tidak bisa update jika presensi sudah dimulai
        if (Carbon::now()->gte($presensi->waktu_mulai)) {
            return redirect()->route('presensi.show', $presensi)
                ->with('error', 'Presensi yang sudah dimulai tidak dapat diupdate');
        }

        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'resume_kelas' => 'required|string',
            'waktu_mulai' => 'required|date|after:now',
            'durasi_menit' => 'required|integer|min:5|max:180',
            'batas_terlambat' => 'required|integer|min:1|max:60', // 1-60 menit
            'prodi' => 'required|array|min:1',
            'prodi.*' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!\App\Models\Unit::where('type', 'program_studi')->where('name', $value)->exists()) {
                    $fail('Program studi yang dipilih tidak valid.');
                }
            }],
            'kelas' => 'required|array|min:1',
            'kelas.*' => 'required|string'
        ]);

        $presensi->update([
            'nama_kelas' => $request->nama_kelas,
            'resume_kelas' => $request->resume_kelas,
            'waktu_mulai' => $request->waktu_mulai,
            'durasi_menit' => (int)$request->durasi_menit,
            'batas_terlambat' => (int)$request->batas_terlambat, // Tambah field
            'prodi' => $request->prodi,
            'kelas' => $request->kelas
        ]);

        // Update waktu selesai
        $presensi->waktu_selesai = Carbon::parse($presensi->waktu_mulai)->addMinutes((int)$presensi->durasi_menit);
        $presensi->save();

        return redirect()->route('presensi.show', $presensi)
            ->with('success', 'Presensi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presensi $presensi)
    {
        // Pastikan hanya dosen yang membuat presensi yang bisa hapus
        if ($presensi->dosen_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Tidak bisa hapus jika presensi sudah dimulai
        if (Carbon::now()->gte($presensi->waktu_mulai)) {
            return redirect()->route('presensi.index')
                ->with('error', 'Presensi yang sudah dimulai tidak dapat dihapus');
        }

        $presensi->delete();

        return redirect()->route('presensi.index')
            ->with('success', 'Presensi berhasil dihapus');
    }

    /**
     * Toggle status aktif presensi
     */
    public function toggleStatus(Presensi $presensi)
    {
        // Pastikan hanya dosen yang membuat presensi yang bisa toggle
        if ($presensi->dosen_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $presensi->is_active = !$presensi->is_active;
        $presensi->save();

        $status = $presensi->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
            ->with('success', "Presensi berhasil {$status}");
    }

    /**
     * Get program studi options for AJAX
     */
    public function getProdiOptions()
    {
        try {
            $prodis = Unit::where('type', 'program_studi')
                ->orderBy('name')
                ->pluck('name')
                ->toArray();

            $result = [];
            foreach($prodis as $prodi) {
                $result[] = ['id' => $prodi, 'nama' => $prodi];
            }

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Error in getProdiOptions: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load prodi data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get kelas options based on prodi for AJAX
     */
    public function getKelasByProdi(Request $request)
    {
        try {
            $prodis = $request->get('prodi');
            
            if (empty($prodis)) {
                return response()->json(['error' => 'Prodi parameter required'], 400);
            }

            // Handle both single prodi (string) and multiple prodis (array)
            if (!is_array($prodis)) {
                $prodis = [$prodis];
            }

            // Get distinct kelas from mahasiswa based on multiple prodi names
            $kelas = Mahasiswa::whereHas('prodi', function($query) use ($prodis) {
                $query->whereIn('name', $prodis);
            })
            ->select('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas')
            ->filter() // Remove null/empty values
            ->values()
            ->toArray();

            return response()->json($kelas);
        } catch (\Exception $e) {
            Log::error('Error in getKelasByProdi: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load kelas data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Export mahasiswa presensi to Excel
     */
    public function exportMahasiswa($id)
    {
        $presensi = Presensi::with(['presensiMahasiswas' => function($query) {
            $query->orderBy('waktu_absen', 'asc');
        }, 'dosen'])->findOrFail($id);

        $filename = 'Presensi_' . str_replace(' ', '_', $presensi->nama_kelas) . '_' . $presensi->waktu_mulai->format('Y-m-d') . '.xlsx';

        // Create Excel content
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $data = [];
        $data[] = ['No', 'NIM', 'Nama Mahasiswa', 'Program Studi', 'Kelas', 'Waktu Absen', 'Status'];
        
        foreach ($presensi->presensiMahasiswas as $index => $mahasiswa) {
            $data[] = [
                $index + 1,
                $mahasiswa->nim,
                $mahasiswa->nama_mahasiswa,
                $mahasiswa->prodi,
                $mahasiswa->kelas,
                $mahasiswa->waktu_absen->format('d/m/Y H:i:s'),
                ucfirst($mahasiswa->status)
            ];
        }

        // Simple Excel export using PHP
        return response()->streamDownload(function () use ($data) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            foreach ($data as $row) {
                fputcsv($file, $row, "\t"); // Use tab separator for Excel
            }
            
            fclose($file);
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
