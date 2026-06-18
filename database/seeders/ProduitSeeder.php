<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produit::create([
            'nom' => 'Cire',
            'caracteristique' => "Brille d'une brillance absolue et immaculé,",
            'prix' => 29.99,
            'image' => null,
        ]);

        Produit::create([
            'nom' => 'Shampoing',
            'caracteristique' => 'Carrosserie, jantes et vitres extérieures aussi palpitante que pure',
            'prix' => 19.99,
            'image' => null,
        ]);
    }
}
