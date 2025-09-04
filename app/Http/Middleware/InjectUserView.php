<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class InjectUserView
{
    public function handle(Request $request, Closure $next)
    {
        $usuario = null;
        // Pega o token da session (não do cookie ou localStorage)
        if ($request->hasSession() && $request->session()->has('jwt_token')) {
            $token = $request->session()->get('jwt_token');
            try {
                $usuario = JWTAuth::setToken($token)->authenticate();
            } catch (\Exception $e) {
                // Token inválido ou expirado
                $usuario = null;
            }
        }
        // Injeta o usuário em todas as views
        view()->share('usuario', $usuario);
        return $next($request);
    }
}
