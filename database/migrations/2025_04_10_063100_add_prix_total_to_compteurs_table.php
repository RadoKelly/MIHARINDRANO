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
        Schema::table('compteurs', function (Blueprint $table) {
            $table->decimal('prix_total', 10, 2)->nullable()->after('frais_compteur');
        });
    }
    
    public function down(): void
    {
        Schema::table('compteurs', function (Blueprint $table) {
            $table->dropColumn('prix_total');
        });
    }
    
};
