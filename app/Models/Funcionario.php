<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    public $timestamps = false;
    protected $table = 'FUNCIONARIO';
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
        return $this->belongsTo(Empresa::class);
    }

    public function funcao()
    {
        return $this->belongsTo(Funcao::class);
    }

    public function obras()
    {
        return $this->belongsToMany(Obra::class, 'FUNCIONARIO_OBRA')
            ->withPivot(['DATA_INICIO', 'DATA_FIM']);
    }

    public function epis()
    {
        return $this->belongsToMany(EPI::class, 'FUNCIONARIO_EPI')
            ->withPivot(['QUANTIDADE', 'DATA_ENTREGA', 'DATA_DEVOLUCAO', 'RESPONSAVEL_ENTREGA']);
    }
}
