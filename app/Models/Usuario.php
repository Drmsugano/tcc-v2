<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Usuario extends Authenticatable implements JWTSubject
{
    public $timestamps = false;
    protected $table = 'USUARIOS';
    protected $primaryKey = 'ID';
    protected $fillable = [
        'NOME',
        'USUARIO',
        'EMAIL',
        'PASSWORD',
        'EMPRESA_ID',
        'PUBLIC_ID'
    ];
    // Esconde automaticamente no JSON/array
    protected $hidden = [
        'PASSWORD',
        'EMPRESA_ID',
        'IS_DELETED'
    ];
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'EMPRESA_ID', 'ID');
    }

    public function permissoes()
    {
        return $this->belongsToMany(
            related: Permissao::class,
            table: 'USUARIO_PERMISSAO',
            foreignPivotKey: 'USUARIO_ID',
            relatedPivotKey: 'PERMISSAO_ID'
        );
    }

    public function permissoesArray()
    {
        return $this->permissoes->pluck('NOME_PERMISSAO')->toArray();
    }

    public function episCadastrados()
    {
        return $this->hasMany(related: EPI::class, foreignKey: 'USUARIO_CADASTRO');
    }

    public function episAlterados()
    {
        return $this->hasMany(related: EPI::class, foreignKey: 'USUARIO_ALTERACAO');
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
