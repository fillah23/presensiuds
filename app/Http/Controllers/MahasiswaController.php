<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::with(['fakultas', 'prodi'])
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.mahasiswa.index', compact('mahasiswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fakultas = Unit::fakultas()->active()->orderBy('name')->get();
        return view('admin.mahasiswa.create', compact('fakultas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|unique:mahasiswas,nim',
            'nama_lengkap' => 'required|string|max:255',
            'fakultas_id' => 'required|exists:units,id',
            'prodi_id' => 'required|exists:units,id',
            'kelas' => 'required|string|max:50',
        ]);

        // Validate that prodi belongs to selected fakultas
        $prodi = Unit::find($request->prodi_id);
        if ($prodi->parent_id != $request->fakultas_id) {
            return back()->withErrors(['prodi_id' => 'Program studi tidak sesuai dengan fakultas yang dipilih.'])->withInput();
        }

        Mahasiswa::create([
            'nim' => $request->nim,
            'nama_lengkap' => $request->nama_lengkap,
            'fakultas_id' => $request->fakultas_id,
            'prodi_id' => $request->prodi_id,
            'kelas' => $request->kelas,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load(['fakultas', 'prodi']);
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $fakultas = Unit::fakultas()->active()->orderBy('name')->get();
        $prodis = Unit::programStudi()->where('parent_id', $mahasiswa->fakultas_id)->orderBy('name')->get();
        
        return view('admin.mahasiswa.edit', compact('mahasiswa', 'fakultas', 'prodis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nim' => 'required|string|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama_lengkap' => 'required|string|max:255',
            'fakultas_id' => 'required|exists:units,id',
            'prodi_id' => 'required|exists:units,id',
            'kelas' => 'required|string|max:50',
        ]);

        // Validate that prodi belongs to selected fakultas
        $prodi = Unit::find($request->prodi_id);
        if ($prodi->parent_id != $request->fakultas_id) {
            return back()->withErrors(['prodi_id' => 'Program studi tidak sesuai dengan fakultas yang dipilih.'])->withInput();
        }

        $mahasiswa->update([
            'nim' => $request->nim,
            'nama_lengkap' => $request->nama_lengkap,
            'fakultas_id' => $request->fakultas_id,
            'prodi_id' => $request->prodi_id,
            'kelas' => $request->kelas,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return response()->json(['success' => true, 'message' => 'Data mahasiswa berhasil dihapus.']);
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        return view('admin.mahasiswa.import');
    }

    /**
     * Download template Excel
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = ['NIM', 'NAMA LENGKAP', 'FAKULTAS', 'PRODI', 'KELAS'];
        $sheet->fromArray($headers, null, 'A1');

        // Style header row
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2E8F0']
            ]
        ];
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

        // Add sample data
        $sampleData = [
            ['2023001001', 'Ahmad Rizki Pratama', 'Fakultas Teknik', 'Teknik Informatika', 'TI-1A'],
            ['2023001002', 'Siti Aminah', 'Fakultas Teknik', 'Sistem Informasi', 'SI-1B'],
            ['2023002001', 'Budi Santoso', 'Fakultas Matematika dan Ilmu Pengetahuan Alam', 'Matematika', 'MAT-1A'],
        ];
        $sheet->fromArray($sampleData, null, 'A2');

        // Auto-size columns
        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'template_mahasiswa.xlsx';
        $tempPath = storage_path('app/temp/' . $filename);

        // Create temp directory if not exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $writer->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend();
    }

    /**
     * Import Excel data
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Remove header row
            array_shift($rows);

            $imported = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 because we removed header and Excel starts from 1

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                $nim = trim($row[0] ?? '');
                $nama = trim($row[1] ?? '');
                $fakultasName = trim($row[2] ?? '');
                $prodiName = trim($row[3] ?? '');
                $kelas = trim($row[4] ?? '');

                // Validate required fields
                if (empty($nim) || empty($nama) || empty($fakultasName) || empty($prodiName) || empty($kelas)) {
                    $errors[] = "Baris {$rowNumber}: Data tidak lengkap";
                    continue;
                }

                // Find fakultas
                $fakultas = Unit::fakultas()->where('name', $fakultasName)->first();
                if (!$fakultas) {
                    $errors[] = "Baris {$rowNumber}: Fakultas '{$fakultasName}' tidak ditemukan";
                    continue;
                }

                // Find prodi
                $prodi = Unit::programStudi()
                    ->where('name', $prodiName)
                    ->where('parent_id', $fakultas->id)
                    ->first();
                if (!$prodi) {
                    $errors[] = "Baris {$rowNumber}: Program Studi '{$prodiName}' tidak ditemukan di fakultas '{$fakultasName}'";
                    continue;
                }

                // Check if NIM already exists
                if (Mahasiswa::where('nim', $nim)->exists()) {
                    $errors[] = "Baris {$rowNumber}: NIM '{$nim}' sudah ada";
                    continue;
                }

                // Create mahasiswa
                Mahasiswa::create([
                    'nim' => $nim,
                    'nama_lengkap' => $nama,
                    'fakultas_id' => $fakultas->id,
                    'prodi_id' => $prodi->id,
                    'kelas' => $kelas,
                    'is_active' => true,
                ]);

                $imported++;
            }

            DB::commit();

            $message = "Import selesai. {$imported} data berhasil diimport.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " data gagal diimport.";
            }

            return back()->with('success', $message)->with('import_errors', $errors);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    /**
     * Get prodis by fakultas (AJAX)
     */
    public function getProdisByFakultas(Request $request)
    {
        $fakultasId = $request->fakultas_id;
        $prodis = Unit::programStudi()
            ->where('parent_id', $fakultasId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($prodis);
    }
}
