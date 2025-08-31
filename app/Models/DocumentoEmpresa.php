<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoEmpresa extends Model
{
    protected $table = 'DOCUMENTOS_EMPRESA';
    protected $timestamp = false;
    protected $fillable = [
        'EMPRESA_ID',
        'NOME',
        'DESCRICAO',
        'TIPO',
        'DATA_EMISSAO',
        'DATA_VALIDADE',
        'ARQUIVO_PATH',
        'IS_DELETED',
        'USUARIO_CADASTRO',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'EMPRESA_ID');
    }
}
