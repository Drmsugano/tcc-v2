<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'EMPRESA';
    protected $timestamp = false;
    protected $fillable = [
        'RAZAO_SOCIAL',
        'NOME_FANTASIA',
        'CNPJ_CPF',
        'IS_DELETED',
    ];

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'EMPRESA_ID');
    }

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'EMPRESA_ID');
    }

    public function documentos()
    {
        return $this->hasMany(DocumentoEmpresa::class, 'EMPRESA_ID');
    }
}
