<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    public $timestamps = false;
    protected $table = 'PERMISSOES';
    protected $primaryKey = 'ID';
    protected $fillable = [
        'NOME_PERMISSAO',
        'DESCRICAO',
        'PUBLIC_ID'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'USUARIO_PERMISSAO', 'PERMISSAO_ID', 'USUARIO_ID');
    }
    protected $hidden = [
        'ID',
        'pivot', // oculta a tabela pivô automaticamente
    ];
}
