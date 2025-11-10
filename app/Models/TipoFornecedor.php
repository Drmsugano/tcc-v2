<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class TipoFornecedor extends Model
{
    use HasFactory;

    protected $table = 'TIPO_FORNECEDOR';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'TIPO',
        'DESCRICAO',
        'PUBLIC_ID',
    ];
    public function fornecedores()
    {
        return $this->belongsTo(Fornecedor::class, 'TIPO_FORNECEDOR_ID', 'ID');
    }
}