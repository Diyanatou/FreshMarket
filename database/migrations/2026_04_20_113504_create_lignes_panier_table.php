<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('lignes_panier', function (Blueprint $table) {
        $table->id();
        $table->foreignId('panier_id')->constrained()->cascadeOnDelete();
        $table->foreignId('produit_id')->constrained()->cascadeOnDelete();
        $table->integer('quantite');
        $table->timestamps();

        $table->unique(['panier_id', 'produit_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('lignes_panier');
}
};
