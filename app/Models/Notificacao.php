<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $fillable = [
        'user_id', 'titulo', 'mensagem', 'tipo', 'lida'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
