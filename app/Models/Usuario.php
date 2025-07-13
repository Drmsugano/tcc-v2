<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'USUARIOS';

    protected $fillable = [
        'NOME', 'EMAIL', 'PASSWORD', 'PERFIL', 'EMPRESA_ID'
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

    // Métodos exigidos pelo JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
