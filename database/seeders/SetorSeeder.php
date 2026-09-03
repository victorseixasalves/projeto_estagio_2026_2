<?php

namespace Database\Seeders;

use App\Models\Setor;
use Illuminate\Database\Seeder;

class SetorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setores = [
            'Norte',
            'Sul',
            'Maracanã Mais',
            'Visitante',
        ];

        foreach ($setores as $nome) {
            Setor::firstOrCreate(['nome' => $nome]);
        }
    }
}