<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'superadmin',
                'display_name' => 'Super Admin',
                'description' => 'Dapat mengakses semua fitur sistem Presensi'
            ],
            [
                'name' => 'dosen',
                'display_name' => 'Dosen',
                'description' => 'Dapat melakukan Presensi dan melihat data Presensi sendiri'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
