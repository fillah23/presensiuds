<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambah role KMK ke tabel roles jika belum ada
        if (!DB::table('roles')->where('name', 'kmk')->exists()) {
            DB::table('roles')->insert([
                'name' => 'kmk',
                'display_name' => 'Koordinator Mata Kuliah',
                'description' => 'Koordinator Mata Kuliah yang dapat membantu dosen mengelola presensi',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Tambah field parent_dosen_id ke tabel users untuk KMK
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_dosen_id')->nullable()->after('role_id');
            $table->foreign('parent_dosen_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus role KMK
        DB::table('roles')->where('name', 'kmk')->delete();

        // Hapus field parent_dosen_id
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['parent_dosen_id']);
            $table->dropColumn('parent_dosen_id');
        });
    }
};
