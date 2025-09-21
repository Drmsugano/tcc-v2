<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Auth\AuthenticationException;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->session()->get('jwt_token');

        if (!$token) {
            throw new AuthenticationException('Usuário não autenticado');
        }

        try {
            $user = JWTAuth::setToken($token)->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            throw new AuthenticationException('Token expirado');
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            throw new AuthenticationException('Token inválido');
        }

        if (!$user) {
            throw new AuthenticationException('Usuário não encontrado');
        }

        $request->attributes->set('jwt_user', $user);

        return $next($request);
    }
}
