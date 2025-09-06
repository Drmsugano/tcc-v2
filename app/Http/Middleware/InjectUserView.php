<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class InjectUserView
{
    public function handle(Request $request, Closure $next)
    {
        $usuarioView = null;
        if ($request->hasSession() && $request->session()->has('jwt_token')) {
            $token = $request->session()->get('jwt_token');
            try {
                $usuarioView = JWTAuth::setToken($token)->authenticate();
            } catch (\Exception $e) {
                // Token inválido ou expirado
                $usuarioView = null;
            }
        }
        view()->share('usuarioView', $usuarioView);
        return $next($request);
    }
}
