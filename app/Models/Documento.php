<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'funcionario_id', 'tipo', 'descricao', 'data_emissao', 'data_validade', 'arquivo'
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }
}
