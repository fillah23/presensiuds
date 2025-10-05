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
        Schema::table('presensis', function (Blueprint $table) {
            // Convert existing data before changing column type
            DB::statement("UPDATE presensis SET prodi = JSON_ARRAY(prodi) WHERE prodi IS NOT NULL AND prodi != ''");
            
            // Change column type from string to json
            $table->json('prodi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            // Convert JSON back to string (take first element)
            DB::statement("UPDATE presensis SET prodi = JSON_UNQUOTE(JSON_EXTRACT(prodi, '$[0]')) WHERE prodi IS NOT NULL");
            
            // Change column type back to string
            $table->string('prodi')->nullable()->change();
        });
    }
};
