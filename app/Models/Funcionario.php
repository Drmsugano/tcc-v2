<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = [
        'empresa_id', 'nome', 'cpf', 'matricula', 'cargo', 'data_admissao'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function entregasEpi()
    {
        return $this->hasMany(EntregaEpi::class);
    }
}
