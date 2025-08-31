<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'FUNCIONARIOS';
    protected $timestamp = false;
    protected $fillable = [
        'NOME',
        'EMAIL',
        'TELEFONE',
        'DATA_ADMISSAO',
        'DATA_DEMISSAO',
        'IS_DELETED',
        'EMPRESA_ID',
        'FUNCAO_ID',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'EMPRESA_ID');
    }

    public function funcao()
    {
        return $this->belongsTo(Funcao::class, 'FUNCAO_ID');
    }

    public function documentos()
    {
        return $this->hasMany(DocumentoFuncionario::class, 'FUNCIONARIO_ID');
    }

    public function epis()
    {
        return $this->hasMany(EntregaEpi::class, 'FUNCIONARIO_ID');
    }
}
