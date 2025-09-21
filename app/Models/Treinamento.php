<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treinamento extends Model
{
    protected $table = 'TREINAMENTOS';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'NOME',
        'NR',
        'VALIDADE_MESES',
        'PUBLIC_ID'
    ];

    // Um treinamento pode ser feito por vários funcionários
    public function funcionarios()
    {
        return $this->belongsToMany(Funcionario::class, 'FUNCIONARIO_TREINAMENTO', 'TREINAMENTO_ID', 'FUNCIONARIO_ID')
                    ->withPivot('DATA_REALIZACAO', 'DATA_VALIDADE', 'RESPONSAVEL');
    }
}
