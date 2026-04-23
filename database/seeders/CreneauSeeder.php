<?php

namespace Database\Seeders;

use App\Models\CreneauLivraison;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CreneauSeeder extends Seeder
{
    public function run()
    {
        $today = Carbon::today();
        
        for ($i = 1; $i <= 7; $i++) {
            $date = $today->copy()->addDays($i);
            
            // Créneaux du matin
            CreneauLivraison::create([
                'date' => $date,
                'heure_debut' => '08:00:00',
                'heure_fin' => '12:00:00',
                'capacite_max' => 10,
                'statut' => 'ouvert',
            ]);
            
            // Créneaux de l'après-midi
            CreneauLivraison::create([
                'date' => $date,
                'heure_debut' => '14:00:00',
                'heure_fin' => '18:00:00',
                'capacite_max' => 10,
                'statut' => 'ouvert',
            ]);
        }
    }
}
