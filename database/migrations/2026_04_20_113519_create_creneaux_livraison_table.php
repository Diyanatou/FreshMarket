<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('creneaux_livraison', function (Blueprint $table) {
        $table->id();
        $table->date('date')->index();
        $table->time('heure_debut');
        $table->time('heure_fin');
        $table->unsignedInteger('capacite_max');
        $table->unsignedInteger('nombre_commandes')->default(0);
        $table->enum('statut', ['ouvert', 'ferme'])->default('ouvert');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('creneaux_livraison');
}
};
