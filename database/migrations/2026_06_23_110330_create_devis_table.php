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
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->string('client_nom');
            $table->string('client_email');
            $table->string('client_telephone')->nullable();
            $table->decimal('total_ht', 8, 2);
            $table->enum('statut', ['en_attente', 'accepte', 'refuse'])->default('en_attente');
            $table->string('fichier_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};
