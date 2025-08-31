<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'USUARIOS';
    protected $primaryKey = 'ID';
    protected $timestamp = false;
    protected $fillable = [
        'NOME',
        'EMAIL',
        'PASSWORD',
        'ROSFIELD_CONTROLE',
        'ROSFIELD_FINANCEIRO',
        'ROSFIELD_GERENCIAL',
        'ROSFIELD_ADMIN',
        'EMPRESA_ID'
    ];

    protected $hidden = [
        'PASSWORD'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function logs()
    {
        return $this->hasMany(LogSistema::class);
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
