<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $fillable = ['nome', 'ativo'];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    /**
     * Retorna apenas os planos ativos (visíveis no formulário público).
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }
}