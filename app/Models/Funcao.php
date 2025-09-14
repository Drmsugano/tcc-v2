<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
    public $timestamps = false;
    protected $table = 'FUNCAO';
    protected $fillable = [
        'NOME',
        'SETOR_ID',
        'EMPRESA_ID',
        'PUBLIC_ID'
    ];

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
}
