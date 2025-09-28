<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentacaoObra extends Model
{
    protected $table = 'DOCUMENTACAO_OBRA';
    public $timestamps = false;

    protected $fillable = [
        'OBRA_ID',
        'TIPO_DOCUMENTO_ID',
        'NOME_ARQUIVO',
        'CAMINHO',
        'DESCRICAO',
        'PUBLIC_ID',
        'DATA_UPLOAD'
    ];

    public function obra()
    {
        return $this->belongsTo(Obra::class, 'OBRA_ID');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoDocumento::class, 'TIPO_DOCUMENTO_ID');
    }
}
