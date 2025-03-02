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
        Schema::create('consommations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('id_compteur');
            $table->string('nouvel_index');
            $table->date('date_recupration');
            $table->timestamps();

            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('id_compteur')->references('id')->on('compteurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consommations');
    }
};
