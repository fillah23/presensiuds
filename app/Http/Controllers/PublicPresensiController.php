<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\PresensiMahasiswa;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicPresensiController extends Controller
{
    /**
     * Halaman utama public presensi dengan kode
     */
    public function index(Request $request)
    {
        $kode = $request->get('kode');
        $presensi = null;
        $error = null;

        if ($kode) {
            $presensi = Presensi::where('kode_presensi', strtoupper($kode))
                ->where('is_active', true)
                ->first();

            if (!$presensi) {
                $error = 'Kode presensi tidak ditemukan';
            }
            // Hapus pengecekan isActive() agar bisa tetap menampilkan presensi yang sudah berakhir atau belum mulai
        }

        return view('public.presensi.index', compact('presensi', 'error', 'kode'));
    }

    /**
     * Proses submit presensi mahasiswa
     */
    public function submit(Request $request)
    {
        $request->validate([
            'kode_presensi' => 'required|string',
            'nim' => 'required|string'
        ]);

        // Cari presensi berdasarkan kode
        $presensi = Presensi::where('kode_presensi', strtoupper($request->kode_presensi))
            ->where('is_active', true)
            ->first();

        if (!$presensi) {
            return response()->json([
                'success' => false,
                'message' => 'Kode presensi tidak ditemukan atau tidak aktif'
            ]);
        }

        // Cek apakah presensi masih aktif
        if (!$presensi->isActive()) {
            return response()->json([
                'success' => false,
                'message' => 'Presensi sudah berakhir atau belum dimulai'
            ]);
        }

        // Cari mahasiswa berdasarkan NIM dengan eager load prodi
        $mahasiswa = Mahasiswa::with('prodi')->where('nim', $request->nim)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'NIM tidak ditemukan dalam database'
            ]);
        }

        // Cek apakah mahasiswa sesuai dengan prodi presensi
        // Membandingkan nama prodi mahasiswa dengan nama prodi presensi
        if ($mahasiswa->prodi->name !== $presensi->prodi) {
            return response()->json([
                'success' => false,
                'message' => "Anda tidak terdaftar dalam program studi untuk presensi ini. Presensi ini khusus untuk: {$presensi->prodi}"
            ]);
        }

        // Cek apakah sudah pernah absen
        $existingPresensi = PresensiMahasiswa::where('presensi_id', $presensi->id)
            ->where('nim', $request->nim)
            ->first();

        if ($existingPresensi) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan presensi sebelumnya'
            ]);
        }

        // Tentukan status (hadir atau terlambat)
        $waktuSekarang = Carbon::now();
        $waktuMulai = $presensi->waktu_mulai;
        $batasTerlambat = $waktuMulai->copy()->addMinutes(15); // 15 menit toleransi
        
        $status = $waktuSekarang->lte($batasTerlambat) ? 'hadir' : 'terlambat';

        // Simpan presensi mahasiswa
        PresensiMahasiswa::create([
            'presensi_id' => $presensi->id,
            'nim' => $mahasiswa->nim,
            'nama_mahasiswa' => $mahasiswa->nama_lengkap,
            'prodi' => $mahasiswa->prodi->name,
            'kelas' => $mahasiswa->kelas,
            'waktu_absen' => $waktuSekarang,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => $status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil dicatat',
            'data' => [
                'nama' => $mahasiswa->nama_lengkap,
                'nim' => $mahasiswa->nim,
                'prodi' => $mahasiswa->prodi->name,
                'kelas' => $mahasiswa->kelas,
                'status' => $status,
                'waktu' => $waktuSekarang->format('H:i:s')
            ]
        ]);
    }

    /**
     * API untuk mendapatkan info presensi real-time
     */
    public function getPresensiInfo(Request $request)
    {
        $kode = $request->get('kode');
        
        $presensi = Presensi::where('kode_presensi', strtoupper($kode))
            ->first(); // Remove where is_active = true so we can show expired presensi

        if (!$presensi) {
            return response()->json([
                'success' => false,
                'message' => 'Presensi tidak ditemukan'
            ]);
        }

        $now = Carbon::now();
        $waktuMulai = Carbon::parse($presensi->waktu_mulai);
        $waktuSelesai = Carbon::parse($presensi->waktu_selesai);
        
        // Status presensi: belum_mulai, berlangsung, berakhir
        $status = 'berlangsung';
        $remainingTime = '';
        
        if ($now->lt($waktuMulai)) {
            $status = 'belum_mulai';
            $diff = $now->diff($waktuMulai);
            if ($diff->days > 0) {
                $remainingTime = "Mulai dalam {$diff->days} hari, {$diff->h} jam, {$diff->i} menit";
            } elseif ($diff->h > 0) {
                $remainingTime = "Mulai dalam {$diff->h} jam, {$diff->i} menit";
            } else {
                $remainingTime = "Mulai dalam {$diff->i} menit, {$diff->s} detik";
            }
        } elseif ($now->gt($waktuSelesai)) {
            $status = 'berakhir';
            $remainingTime = 'Presensi telah berakhir';
        } else {
            $remainingTime = $presensi->getRemainingTime();
        }
        $isActive = $presensi->isActive() && $status === 'berlangsung';
        $totalAbsen = $presensi->getAbsentMahasiswas();

        return response()->json([
            'success' => true,
            'data' => [
                'remaining_time' => $remainingTime,
                'is_active' => $isActive,
                'status' => $status,
                'total_absen' => $totalAbsen,
                'nama_kelas' => $presensi->nama_kelas,
                'dosen' => $presensi->dosen->name,
                'waktu_mulai' => $presensi->waktu_mulai->format('H:i'),
                'waktu_selesai' => $presensi->waktu_selesai->format('H:i')
            ]
        ]);
    }

    /**
     * Halaman untuk display countdown (untuk proyektor/layar besar)
     */
    public function display($kode)
    {
        $presensi = Presensi::where('kode_presensi', strtoupper($kode))
            ->with(['dosen', 'presensiMahasiswas' => function($query) {
                $query->orderBy('waktu_absen', 'desc');
            }])
            ->first();

        if (!$presensi) {
            abort(404, 'Presensi tidak ditemukan');
        }

        // Get total mahasiswa berdasarkan nama prodi (join dengan units table)
        $totalMahasiswa = Mahasiswa::whereHas('prodi', function($query) use ($presensi) {
            $query->where('name', $presensi->prodi);
        })->count();

        return view('public.presensi.display', compact('presensi', 'totalMahasiswa'));
    }
}
