<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('commandes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('utilisateur_id')
              ->constrained('users')
              ->cascadeOnDelete();
        $table->foreignId('creneau_id')
              ->constrained('creneaux_livraison')
              ->cascadeOnDelete();
        $table->enum('statut', ['en_attente', 'confirmee', 'annulee', 'livree'])
              ->default('en_attente');
        $table->decimal('prix_total', 10, 2);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('commandes');
}
};
