<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'TIPO_DOCUMENTO';
    public $timestamps = false;
    protected $fillable = ['NOME', 'DESCRICAO'];

    public function documentosObra()
    {
        return $this->hasMany(DocumentacaoObra::class, 'TIPO_DOCUMENTO_ID');
    }
}
