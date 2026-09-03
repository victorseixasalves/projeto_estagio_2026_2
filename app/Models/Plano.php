<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $fillable = ['nome', 'ativo', 'beneficios', 'destaque'];

    protected $casts = [
        'ativo' => 'boolean',
        'destaque' => 'boolean',
    ];

    /**
     * Retorna apenas os planos ativos (visíveis no formulário público).
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Transforma o texto de benefícios (um por linha) numa lista utilizável na view.
     */
    public function getBeneficiosListaAttribute(): array
    {
        if (! $this->beneficios) {
            return [];
        }

        return array_filter(array_map('trim', explode("\n", $this->beneficios)));
    }
}