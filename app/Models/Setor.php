<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    protected $table = 'setores';

    protected $fillable = ['nome', 'ativo'];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    /**
     * Retorna apenas os setores ativos (visíveis no formulário público).
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }
}