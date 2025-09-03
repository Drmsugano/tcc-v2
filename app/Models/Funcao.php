<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
    protected $table = 'FUNCAO';
    protected $timestamp = false;
    protected $fillable = ['NOME', 'SETOR_ID'];

    public function setor()
    {
        return $this->belongsTo(Setor::class, 'setor_id');
    }

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'funcao_id');
    }
}
