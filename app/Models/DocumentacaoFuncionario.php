<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentacaoFuncionario extends Model
{
    protected $table = 'DOCUMENTACAO_FUNCIONARIO';
    public $timestamps = false;
    protected $fillable = ['FUNCIONARIO_ID', 'TIPO_DOCUMENTO_ID', 'NOME_ARQUIVO', 'CAMINHO', 'DESCRICAO', 'PUBLIC_ID'];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'FUNCIONARIO_ID');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoDocumento::class, 'TIPO_DOCUMENTO_ID');
    }
}
