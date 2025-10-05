<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\Unit;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing units
        $ft = Unit::where('code', 'FT')->first();
        $fmipa = Unit::where('code', 'FMIPA')->first();
        $feb = Unit::where('code', 'FEB')->first();

        $ti = Unit::where('code', 'TI')->first();
        $si = Unit::where('code', 'SI')->first();
        $mat = Unit::where('code', 'MAT')->first();
        $mnj = Unit::where('code', 'MNJ')->first();

        if (!$ft || !$ti || !$si || !$mat || !$mnj) {
            $this->command->error('Units not found. Please run UnitSeeder first.');
            return;
        }

        // Sample mahasiswa data
        $mahasiswas = [
            // Teknik Informatika
            [
                'nim' => '2023001001',
                'nama_lengkap' => 'Ahmad Rizki Pratama',
                'fakultas_id' => $ft->id,
                'prodi_id' => $ti->id,
                'kelas' => 'TI-1A',
                'is_active' => true
            ],
            [
                'nim' => '2023001002',
                'nama_lengkap' => 'Siti Nurhaliza',
                'fakultas_id' => $ft->id,
                'prodi_id' => $ti->id,
                'kelas' => 'TI-1A',
                'is_active' => true
            ],
            [
                'nim' => '2023001003',
                'nama_lengkap' => 'Budi Santoso',
                'fakultas_id' => $ft->id,
                'prodi_id' => $ti->id,
                'kelas' => 'TI-1B',
                'is_active' => true
            ],
            [
                'nim' => '2023001004',
                'nama_lengkap' => 'Diana Putri',
                'fakultas_id' => $ft->id,
                'prodi_id' => $ti->id,
                'kelas' => 'TI-2A',
                'is_active' => true
            ],

            // Sistem Informasi
            [
                'nim' => '2023002001',
                'nama_lengkap' => 'Eko Prasetyo',
                'fakultas_id' => $ft->id,
                'prodi_id' => $si->id,
                'kelas' => 'SI-1A',
                'is_active' => true
            ],
            [
                'nim' => '2023002002',
                'nama_lengkap' => 'Fitri Andriani',
                'fakultas_id' => $ft->id,
                'prodi_id' => $si->id,
                'kelas' => 'SI-1B',
                'is_active' => true
            ],
            [
                'nim' => '2023002003',
                'nama_lengkap' => 'Gilang Ramadhan',
                'fakultas_id' => $ft->id,
                'prodi_id' => $si->id,
                'kelas' => 'SI-2A',
                'is_active' => true
            ],

            // Matematika
            [
                'nim' => '2023003001',
                'nama_lengkap' => 'Hendra Wijaya',
                'fakultas_id' => $fmipa->id,
                'prodi_id' => $mat->id,
                'kelas' => 'MAT-1A',
                'is_active' => true
            ],
            [
                'nim' => '2023003002',
                'nama_lengkap' => 'Indah Sari',
                'fakultas_id' => $fmipa->id,
                'prodi_id' => $mat->id,
                'kelas' => 'MAT-1A',
                'is_active' => true
            ],
            [
                'nim' => '2023003003',
                'nama_lengkap' => 'Joko Susilo',
                'fakultas_id' => $fmipa->id,
                'prodi_id' => $mat->id,
                'kelas' => 'MAT-2A',
                'is_active' => true
            ],

            // Manajemen
            [
                'nim' => '2023004001',
                'nama_lengkap' => 'Karina Salsabila',
                'fakultas_id' => $feb->id,
                'prodi_id' => $mnj->id,
                'kelas' => 'MNJ-1A',
                'is_active' => true
            ],
            [
                'nim' => '2023004002',
                'nama_lengkap' => 'Lukman Hakim',
                'fakultas_id' => $feb->id,
                'prodi_id' => $mnj->id,
                'kelas' => 'MNJ-1B',
                'is_active' => true
            ],
            [
                'nim' => '2023004003',
                'nama_lengkap' => 'Maya Puspita',
                'fakultas_id' => $feb->id,
                'prodi_id' => $mnj->id,
                'kelas' => 'MNJ-2A',
                'is_active' => true
            ],
            [
                'nim' => '2023004004',
                'nama_lengkap' => 'Nur Rahman',
                'fakultas_id' => $feb->id,
                'prodi_id' => $mnj->id,
                'kelas' => 'MNJ-2B',
                'is_active' => true
            ],

            // Additional students for variety
            [
                'nim' => '2022001001',
                'nama_lengkap' => 'Omar Khayyam',
                'fakultas_id' => $ft->id,
                'prodi_id' => $ti->id,
                'kelas' => 'TI-3A',
                'is_active' => true
            ],
            [
                'nim' => '2022001002',
                'nama_lengkap' => 'Putri Maharani',
                'fakultas_id' => $ft->id,
                'prodi_id' => $si->id,
                'kelas' => 'SI-3A',
                'is_active' => true
            ],
        ];

        foreach ($mahasiswas as $mahasiswa) {
            Mahasiswa::create($mahasiswa);
        }

        $this->command->info('Sample mahasiswa data created successfully.');
    }
}