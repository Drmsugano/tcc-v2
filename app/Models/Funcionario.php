<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    public $timestamps = false;
    protected $table = 'FUNCIONARIOS';
    protected $fillable = [
        'NOME',
        'CPF',
        'DATA_ADMISSAO',
        'DATA_DEMISSAO',
        'EMPRESA_ID',
        'FUNCAO_ID',
        'PUBLIC_ID'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class,'EMPRESA_ID', 'ID');
    }

    public function funcao()
    {
        return $this->belongsTo(Funcao::class, 'FUNCAO_ID', 'ID');
    }

    public function obras()
    {
        return $this->belongsToMany(Obra::class, 'FUNCIONARIO_OBRA', 'FUNCIONARIO_ID', 'OBRA_ID');
    }

    public function epis()
    {
        return $this->belongsToMany(EPI::class, 'FUNCIONARIO_EPI')
            ->withPivot(['QUANTIDADE', 'DATA_ENTREGA', 'DATA_DEVOLUCAO', 'RESPONSAVEL_ENTREGA']);
    }
}
