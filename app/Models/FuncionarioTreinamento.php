<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuncionarioTreinamento extends Model
{
    protected $table = 'FUNCIONARIO_TREINAMENTO';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'FUNCIONARIO_ID',
        'TREINAMENTO_ID',
        'DATA_REALIZACAO',
        'DATA_VALIDADE',
        'RESPONSAVEL'
    ];

    // Relacionamento com o Funcionário
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'FUNCIONARIO_ID', 'ID');
    }

    // Relacionamento com o Treinamento
    public function treinamento()
    {
        return $this->belongsTo(Treinamento::class, 'TREINAMENTO_ID', 'ID');
    }
}
