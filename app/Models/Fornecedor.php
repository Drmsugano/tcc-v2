<?php
namespace App\Models;

use App\Http\Traits\softDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoFornecedor;
class Fornecedor extends Model
{
    use HasFactory, softDelete;

    protected $table = 'FORNECEDOR';
    protected $primaryKey = 'PUBLIC_ID';
    public $timestamps = false;
    protected $fillable = [
        'NOME',
        'CNPJ',
        'ENDERECO',
        'CIDADE',
        'ESTADO',
        'CEP',
        'TELEFONE',
        'USUARIO_CADASTRO',
        'PUBLIC_ID',
        'IS_DELETED',
    ];
    public function tipoFornecedor()
    {
        return $this->hasMany(TipoFornecedor::class, 'ID', 'TIPO_FORNECEDOR_ID');
    }
    public function epis()
    {
        return $this->hasMany(Epi::class, 'FORNECEDOR_EPI', 'ID');
    }
}