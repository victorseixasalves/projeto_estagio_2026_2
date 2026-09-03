<?php

namespace Database\Seeders;

use App\Models\Plano;
use Illuminate\Database\Seeder;

class PlanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $planos = [
            'Tradição Tricolor',
            'Guerreiro do Laranjeiras',
            'Eterno Campeão',
            'FluKids',
        ];

        foreach ($planos as $nome) {
            Plano::firstOrCreate(['nome' => $nome]);
        }
    }
}