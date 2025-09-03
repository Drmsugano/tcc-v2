<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoFuncionario extends Model
{
    protected $table = 'DOCUMENTOS_FUNCIONARIO';
    protected $timestamp = false;
    protected $fillable = [
        'FUNCIONARIO_ID',
        'NOME',
        'DESCRICAO',
        'TIPO',
        'DATA_EMISSAO',
        'DATA_VALIDADE',
        'ARQUIVO_PATH',
        'IS_DELETED',
        'USUARIO_CADASTRO',
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'FUNCIONARIO_ID');
    }
}
