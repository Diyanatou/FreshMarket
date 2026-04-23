<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('lots_produits', function (Blueprint $table) {
        $table->id();
        $table->foreignId('produit_id')->constrained()->cascadeOnDelete();
        $table->integer('quantite');
        $table->date('date_expiration')->nullable()->index();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('lots_produits');
}
};
