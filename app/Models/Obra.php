<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    public $timestamps = false;
    protected $table = 'OBRA';
    protected $fillable = ['NOME_OBRA', 'EMPRESA_ID'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function funcionarios()
    {
        return $this->belongsToMany(Funcionario::class, 'FUNCIONARIO_OBRA')
            ->withPivot(['DATA_INICIO', 'DATA_FIM']);
    }
}
