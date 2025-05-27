<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'user_id', 'acao', 'tabela_afetada', 'registro_id', 'detalhes'
    ];

    public function user()
    {
        return $this->belongsTo(Usuario::class);
    }
}
