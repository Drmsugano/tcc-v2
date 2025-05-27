<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntregaEpi extends Model
{
    protected $table = 'entregas_epi';

    protected $fillable = [
        'funcionario_id', 'epi_id', 'data_entrega', 'validade', 'quantidade', 'observacao'
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function epi()
    {
        return $this->belongsTo(Epi::class);
    }
}
