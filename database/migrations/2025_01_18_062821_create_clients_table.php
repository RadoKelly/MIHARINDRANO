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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_site');
            $table->string('adress_client');
            $table->string('localite');
            $table->string('categorie');
            $table->date('date_raccordement');
            $table->string('ref')->unique();
            $table->string('nom_client');
            $table->timestamps();

            $table->foreign('id_site')->references('id')->on('sites')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
