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
        Schema::create('compteurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id')->nullable(); // champ simple
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // relation client uniquement
            $table->date('date_releve');
            $table->date('ancien_date')->nullable();
            $table->string('numero_facture')->nullable();
            $table->unsignedBigInteger('tarif_id')->nullable(); // champ simple (pas de foreign)
            $table->decimal('ancien_index', 10, 2)->default(0);
            $table->decimal('nouvel_index', 10, 2)->default(0);
            $table->decimal('consommation', 10, 2)->default(0);
            $table->decimal('prix_par_index', 10, 2)->nullable();
            $table->decimal('frais_compteur', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compteurs');
    }
};
