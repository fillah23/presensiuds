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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama unit (fakultas/prodi)
            $table->enum('type', ['fakultas', 'program_studi']); // Jenis unit
            $table->string('code')->nullable(); // Kode unit
            $table->text('description')->nullable(); // Deskripsi
            $table->foreignId('parent_id')->nullable()->constrained('units')->onDelete('cascade'); // Parent untuk prodi
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
