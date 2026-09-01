<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->enum('tipo', [
                'Tradição Tricolor',
                'Guerreiro do Laranjeiras',
                'Eterno Campeão',
                'FluKids',
            ]);
            $table->date('data');
            $table->enum('setor', [
                'Norte',
                'Sul',
                'Maracanã Mais',
                'Visitante',
            ]);
            $table->enum('status', ['pendente', 'confirmado', 'cancelado'])
                ->default('pendente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
