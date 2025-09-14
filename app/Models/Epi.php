<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class EPI extends Model
{
    public $timestamps = false;
    protected $table = 'EPI';
    protected $fillable = [
        'NOME',
        'DESCRICAO',
        'CA',
        'VALIDADE_EPI',
        'USUARIO_CADASTRO',
        'USUARIO_ALTERACAO',
        'PUBLIC_ID'
    ];

    public function usuarioCadastro()
    {
        return $this->belongsTo(Usuario::class, 'USUARIO_CADASTRO');
    }

    public function usuarioAlteracao()
    {
        return $this->belongsTo(Usuario::class, 'USUARIO_ALTERACAO');
    }

    public function funcionarios()
    {
        return $this->belongsToMany(Funcionario::class, 'FUNCIONARIO_EPI')
            ->withPivot(['QUANTIDADE', 'DATA_ENTREGA', 'DATA_DEVOLUCAO', 'RESPONSAVEL_ENTREGA']);
    }
}

