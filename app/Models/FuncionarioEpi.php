<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class FuncionarioEpi extends Model
{
    use HasFactory;
    protected $table = 'FUNCIONARIO_EPI';
    public $timestamps = false;
    protected $fillable = [
        'FUNCIONARIO_ID',
        'EPI_ID',
        'DATA_ENTREGA',
        'QUANTIDADE',
        'DATA_ENTREGA',
        'DATA_DEVOLUCAO',
        'RESPONSAVEL_ENTREGA'
    ];
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'FUNCIONARIO_ID');
    }
    public function epi()
    {
        return $this->belongsTo(Epi::class, 'EPI_ID');
    }
    public function responsavelEntrega()
    {
        return $this->belongsTo(Funcionario::class, 'RESPONSAVEL_ENTREGA');
    }
}