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
        Schema::create('presensi_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presensi_id')->constrained('presensis')->onDelete('cascade');
            $table->string('nim'); // NIM mahasiswa
            $table->string('nama_mahasiswa'); // Nama mahasiswa (dari tabel mahasiswas)
            $table->string('prodi'); // Program studi
            $table->string('kelas')->nullable(); // Kelas
            $table->datetime('waktu_absen'); // Waktu saat mahasiswa absen
            $table->string('ip_address')->nullable(); // IP Address
            $table->text('user_agent')->nullable(); // User Agent Browser
            $table->enum('status', ['hadir', 'terlambat'])->default('hadir');
            $table->timestamps();
            
            $table->unique(['presensi_id', 'nim']); // Satu mahasiswa hanya bisa absen sekali per presensi
            $table->index(['presensi_id', 'waktu_absen']);
            $table->index(['nim', 'waktu_absen']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_mahasiswas');
    }
};
