<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    public $timestamps = false;
    protected $table = 'EMPRESA';
    protected $fillable = [
        'RAZAO_SOCIAL',
        'NOME_FANTASIA',
        'CNPJ_CPF',
        'IS_DELETED',
        'PUBLIC_ID'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }

    public function setores()
    {
        return $this->hasMany(Setor::class);
    }

    public function funcoes()
    {
        return $this->hasMany(Funcao::class);
    }

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }

    public function obras()
    {
        return $this->hasMany(Obra::class);
    }
}
