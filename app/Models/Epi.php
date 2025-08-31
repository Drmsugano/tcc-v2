<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Epi extends Model
{
    protected $table = 'EPI';
    protected $timestamp = false;
    protected $fillable = [
        'NOME',
        'DESCRICAO',
        'CA',
        'VALIDADE_EPI',
        'HORA_CADASTRO',
        'DATA_CADASTRO',
        'USUARIO_CADASTRO',
        'USUARIO_ALTERACAO',
        'IS_DELETED',
    ];

    public function entregas()
    {
        return $this->hasMany(EntregaEpi::class, 'EPI_ID');
    }
}
