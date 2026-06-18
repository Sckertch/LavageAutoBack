<?php

namespace Database\Seeders;

use App\Models\Prestation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrestationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prestation::create([
            'nom' => 'Lavage Intérieur',
            'caracteristique' => 'Aspiration complète, nettoyage des vitres intérieures',
            'prix' => 29.99,
            'image' => null,
        ]);

        Prestation::create([
            'nom' => 'Lavage Extérieur',
            'caracteristique' => 'Carrosserie, jantes et vitres extérieures',
            'prix' => 19.99,
            'image' => null,
        ]);
    }
}
