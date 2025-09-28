<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentacaoEmpresa extends Model
{
    protected $table = 'DOCUMENTACAO_EMPRESA';
    public $timestamps = false;

    protected $fillable = [
        'EMPRESA_ID',
        'TIPO_DOCUMENTO_ID',
        'NOME_ARQUIVO',
        'CAMINHO',
        'DESCRICAO',
        'PUBLIC_ID',
        'DATA_UPLOAD'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'EMPRESA_ID');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoDocumento::class, 'TIPO_DOCUMENTO_ID');
    }
}
