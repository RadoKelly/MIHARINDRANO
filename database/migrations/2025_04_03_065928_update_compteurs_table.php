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
            // Ajout des nouvelles colonnes
            $table->foreignId('site_id')->constrained()->onDelete('cascade'); // Associe le compteur à un site
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Associe le compteur à un client
            $table->date('date_releve'); // Date du relevé
            $table->date('ancien_date')->nullable(); // Ancienne date du relevé
            $table->string('numero_facture')->nullable(); // Numéro de facture
            $table->foreignId('tarif_id')->constrained()->onDelete('cascade'); // Tarif appliqué
            $table->decimal('ancien_index', 10, 2)->default(0); // Ancien index du compteur
            $table->decimal('nouvel_index', 10, 2)->default(0); // Nouvel index du compteur
            $table->decimal('consommation', 10, 2)->virtualAs('nouvel_index - ancien_index'); // Calcul automatique
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compteurs', function (Blueprint $table) {
            $table->dropColumn([
                'site_id', 'client_id', 'date_releve', 'ancien_date', 'numero_facture',
                'tarif_id', 'ancien_index', 'nouvel_index', 'consommation'
            ]);
        });
    }
};
