<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nome', 'email', 'password', 'perfil', 'empresa_id'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function notificacoes()
    {
        return $this->hasMany(Notificacao::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
