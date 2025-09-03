<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    protected $table = 'SETOR';
    protected $timestamp = false;
    protected $fillable = ['NOME'];

    public function funcoes()
    {
        return $this->hasMany(Funcao::class, 'SETOR_ID');
    }
}
