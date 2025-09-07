<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    public $timestamps = false;
    protected $table = 'SETOR';
    protected $fillable = ['NOME', 'EMPRESA_ID'];
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function funcoes()
    {
        return $this->hasMany(Funcao::class);
    }
}
