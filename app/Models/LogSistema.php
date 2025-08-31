<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogSistema extends Model
{
    protected $table = 'LOGS';
    protected $timestamp = false;
    protected $fillable = [
        'USUARIO_ID',
        'ACAO',
        'TABELA',
        'REGISTRO_ID',
        'DESCRICAO',
        'DATA_ACAO',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'USUARIO_ID');
    }
}
