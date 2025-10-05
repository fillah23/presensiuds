<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Fakultas
        $fakultas = [
            [
                'name' => 'Fakultas Teknik',
                'code' => 'FT',
                'type' => 'fakultas',
                'description' => 'Fakultas yang menyelenggarakan program studi bidang teknik dan teknologi',
                'is_active' => true
            ],
            [
                'name' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam',
                'code' => 'FMIPA',
                'type' => 'fakultas',
                'description' => 'Fakultas yang menyelenggarakan program studi bidang matematika dan sains',
                'is_active' => true
            ],
            [
                'name' => 'Fakultas Ekonomi dan Bisnis',
                'code' => 'FEB',
                'type' => 'fakultas',
                'description' => 'Fakultas yang menyelenggarakan program studi bidang ekonomi dan bisnis',
                'is_active' => true
            ],
            [
                'name' => 'Fakultas Agama Islam',
                'code' => 'FAI',
                'type' => 'fakultas',
                'description' => 'Fakultas yang menyelenggarakan program studi bidang agama Islam',
                'is_active' => true
            ]
        ];

        foreach ($fakultas as $fak) {
            Unit::create($fak);
        }

        // Get created fakultas
        $ft = Unit::where('code', 'FT')->first();
        $fmipa = Unit::where('code', 'FMIPA')->first();
        $feb = Unit::where('code', 'FEB')->first();
        $fai = Unit::where('code', 'FAI')->first();

        // Create Program Studi for Fakultas Teknik
        $prodiTeknik = [
            [
                'name' => 'Teknik Informatika',
                'code' => 'TI',
                'type' => 'program_studi',
                'parent_id' => $ft->id,
                'description' => 'Program studi yang mempelajari teknologi informasi dan komputer',
                'is_active' => true
            ],
            [
                'name' => 'Sistem Informasi',
                'code' => 'SI',
                'type' => 'program_studi',
                'parent_id' => $ft->id,
                'description' => 'Program studi yang mempelajari sistem informasi dan manajemen data',
                'is_active' => true
            ],
            [
                'name' => 'Teknik Sipil',
                'code' => 'TS',
                'type' => 'program_studi',
                'parent_id' => $ft->id,
                'description' => 'Program studi yang mempelajari teknik sipil dan konstruksi',
                'is_active' => true
            ]
        ];

        // Create Program Studi for FMIPA
        $prodiFmipa = [
            [
                'name' => 'Matematika',
                'code' => 'MAT',
                'type' => 'program_studi',
                'parent_id' => $fmipa->id,
                'description' => 'Program studi yang mempelajari ilmu matematika murni dan terapan',
                'is_active' => true
            ],
            [
                'name' => 'Fisika',
                'code' => 'FIS',
                'type' => 'program_studi',
                'parent_id' => $fmipa->id,
                'description' => 'Program studi yang mempelajari ilmu fisika dan fenomena alam',
                'is_active' => true
            ]
        ];

        // Create Program Studi for FEB
        $prodiFeb = [
            [
                'name' => 'Manajemen',
                'code' => 'MNJ',
                'type' => 'program_studi',
                'parent_id' => $feb->id,
                'description' => 'Program studi yang mempelajari manajemen bisnis dan organisasi',
                'is_active' => true
            ],
            [
                'name' => 'Akuntansi',
                'code' => 'AKT',
                'type' => 'program_studi',
                'parent_id' => $feb->id,
                'description' => 'Program studi yang mempelajari akuntansi dan keuangan',
                'is_active' => true
            ],
            [
                'name' => 'Ekonomi Pembangunan',
                'code' => 'EP',
                'type' => 'program_studi',
                'parent_id' => $feb->id,
                'description' => 'Program studi yang mempelajari ekonomi pembangunan dan kebijakan',
                'is_active' => true
            ]
        ];

        // Create Program Studi for FAI
        $prodiFai = [
            [
                'name' => 'Pendidikan Agama Islam',
                'code' => 'PAI',
                'type' => 'program_studi',
                'parent_id' => $fai->id,
                'description' => 'Program studi yang mempelajari pendidikan agama Islam',
                'is_active' => true
            ],
            [
                'name' => 'Hukum Ekonomi Syariah',
                'code' => 'HES',
                'type' => 'program_studi',
                'parent_id' => $fai->id,
                'description' => 'Program studi yang mempelajari hukum ekonomi berdasarkan syariah Islam',
                'is_active' => true
            ]
        ];

        // Insert all program studi
        foreach ($prodiTeknik as $prodi) {
            Unit::create($prodi);
        }

        foreach ($prodiFmipa as $prodi) {
            Unit::create($prodi);
        }

        foreach ($prodiFeb as $prodi) {
            Unit::create($prodi);
        }

        foreach ($prodiFai as $prodi) {
            Unit::create($prodi);
        }
    }
}