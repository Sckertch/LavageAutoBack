<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devis_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devis_id')->constrained('devis')->cascadeOnDelete();
            $table->enum('type', ['prestation', 'produit']);
            $table->unsignedInteger('reference_id');
            $table->string('nom');
            $table->decimal('prix_unitaire', 8, 2);
            $table->unsignedInteger('quantite');
            $table->decimal('sous_total', 8, 2);
            $table->timestamps();
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('devis_lignes');
    }
};
