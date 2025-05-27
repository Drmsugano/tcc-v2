<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Epi extends Model
{
    protected $fillable = [
        'nome', 'descricao', 'validade', 'ca', 'quantidade_estoque'
    ];

    public function entregas()
    {
        return $this->hasMany(EntregaEpi::class);
    }
}
