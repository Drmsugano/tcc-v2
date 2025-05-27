<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsavelSeguranca extends Model
{
    protected $fillable = [
        'empresa_id', 'nome', 'cpf', 'formacao', 'numero_registro_profissional', 'telefone', 'email'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
