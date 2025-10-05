<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dapatkan roles
        $superadminRole = Role::where('name', 'superadmin')->first();
        $dosenRole = Role::where('name', 'dosen')->first();

        // Buat Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@uds.ac.id',
            'password' => Hash::make('password'),
            'role_id' => $superadminRole->id,
            'is_active' => true
        ]);

        // Buat contoh Dosen
        User::create([
            'name' => 'Dr. Ahmad Fauzi',
            'email' => 'ahmad.fauzi@uds.ac.id',
            'password' => Hash::make('password'),
            'nuptk' => '1234567890123456',
            'nomor_whatsapp' => '081234567890',
            'role_id' => $dosenRole->id,
            'is_active' => true
        ]);

        User::create([
            'name' => 'Dr. Siti Nurhaliza',
            'email' => 'siti.nurhaliza@uds.ac.id',
            'password' => Hash::make('password'),
            'nuptk' => '1234567890123457',
            'nomor_whatsapp' => '081234567891',
            'role_id' => $dosenRole->id,
            'is_active' => true
        ]);
    }
}
