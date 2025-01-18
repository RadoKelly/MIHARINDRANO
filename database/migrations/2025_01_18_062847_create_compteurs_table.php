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
            $table->unsignedBigInteger('id_client');
            $table->string('numero')->unique();
            $table->integer('nouvel_index');
            $table->date('date_compteur');
            $table->timestamps();

            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
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
