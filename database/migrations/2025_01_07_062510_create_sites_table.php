<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->string('numero_site')->unique(); // Numéro du site (unique)
            $table->string('nom_site'); // Nom du site
            $table->string('technologie'); // Technologie utilisée
            $table->string('etape_avancement')->nullable(); // Étape d'avancement
            $table->string('responsable')->nullable(); // Responsable du site
            $table->date('date_debut_etape')->nullable(); // Date de début de l'étape
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
