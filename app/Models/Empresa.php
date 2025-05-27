<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = ['nome', 'cnpj', 'endereco', 'telefone'];

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }

    public function responsaveisSeguranca()
    {
        return $this->hasMany(ResponsavelSeguranca::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
