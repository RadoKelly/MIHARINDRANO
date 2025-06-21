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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compteur_id')->constrained()->onDelete('cascade'); // Lien avec compteurs
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Lien avec clients
            $table->decimal('montant_paye', 10, 2); // Montant payé
            $table->date('date_paiement'); // Date du paiement
            $table->decimal('reste_a_payer', 10, 2)->default(0.00); // Reste à payer
            $table->enum('statut', ['paye', 'partiel', 'en_attente'])->default('en_attente'); // Statut
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};