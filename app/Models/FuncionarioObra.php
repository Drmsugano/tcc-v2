<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class FuncionarioObra extends Model
{
    protected $table = 'FUNCIONARIO_OBRA';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'FUNCIONARIO_ID',
        'OBRA_ID',
        'DATA_INICIO',
        'DATA_FIM'
    ];
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'FUNCIONARIO_ID', 'ID');
    }
    public function obra()
    {
        return $this->belongsTo(Obra::class, 'OBRA_ID', 'ID');
    }
}