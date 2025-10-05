<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas'); // Nama Kelas/Mata Kuliah
            $table->text('resume_kelas'); // Resume Kelas
            $table->datetime('waktu_mulai'); // Waktu mulai presensi
            $table->integer('durasi_menit'); // Durasi dalam menit (misal 30 menit)
            $table->datetime('waktu_selesai'); // Waktu selesai (calculated)
            $table->string('prodi'); // Program studi yang boleh mengikuti presensi
            $table->foreignId('dosen_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->string('kode_presensi', 10)->unique(); // Kode unik untuk presensi
            $table->timestamps();
            
            $table->index(['is_active', 'waktu_mulai', 'waktu_selesai']);
            $table->index(['nama_kelas', 'waktu_mulai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
