<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles
        $clientRole = \App\Models\Role::create(['nom' => 'client']);
        $adminRole = \App\Models\Role::create(['nom' => 'admin']);

        // 2. Utilisateurs
        \App\Models\User::create([
            'nom' => 'Admin',
            'prenom' => 'System',
            'email' => 'admin@freshmarket.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        \App\Models\User::create([
            'nom' => 'User',
            'prenom' => 'Test',
            'email' => 'user@freshmarket.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role_id' => $clientRole->id,
        ]);

        // 3. Catégories
        $fruits = \App\Models\Categorie::create(['nom' => 'Fruits & Légumes']);
        $epicerie = \App\Models\Categorie::create(['nom' => 'Épicerie']);

        // 4. Produits
        \App\Models\Produit::create([
            'nom' => 'Pommes Bio',
            'description' => 'Belles pommes bio du verger.',
            'prix' => 2.50,
            'image' => 'images/food.png',
            'categorie_id' => $fruits->id,
            'actif' => true,
        ]);

        \App\Models\Produit::create([
            'nom' => 'Bananes',
            'description' => 'Bananes fraîches.',
            'prix' => 1.80,
            'image' => 'images/food2.jpg',
            'categorie_id' => $fruits->id,
            'actif' => true,
        ]);

        \App\Models\Produit::create([
            'nom' => 'Pain Bio',
            'description' => 'Pain artisanal.',
            'prix' => 3.00,
            'image' => 'images/food3.png',
            'categorie_id' => $epicerie->id,
            'actif' => true,
        ]);

        // 5. Créneaux (optionnel si vous avez déjà un seeder pour ça)
        $this->call(CreneauSeeder::class);
    }
}
