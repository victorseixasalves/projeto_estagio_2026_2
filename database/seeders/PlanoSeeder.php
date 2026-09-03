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
            [
                'nome' => 'Tradição Tricolor',
                'beneficios' => "Carteirinha digital\n10% de desconto na loja oficial\nNewsletter exclusiva",
                'destaque' => false,
            ],
            [
                'nome' => 'FluKids',
                'beneficios' => "Valor reduzido até 12 anos\nKit de boas-vindas infantil\nAcesso à área kids no estádio",
                'destaque' => false,
            ],
            [
                'nome' => 'Guerreiro do Laranjeiras',
                'beneficios' => "25% de desconto em ingressos\nFila prioritária de compra\n20% de desconto na loja oficial",
                'destaque' => true,
            ],
            [
                'nome' => 'Eterno Campeão',
                'beneficios' => "Ingresso garantido em todo jogo\nCamisa oficial todo ano\nConvite para eventos do clube",
                'destaque' => false,
            ],
        ];

        foreach ($planos as $dados) {
            Plano::updateOrCreate(
                ['nome' => $dados['nome']],
                ['beneficios' => $dados['beneficios'], 'destaque' => $dados['destaque']]
            );
        }
    }
}