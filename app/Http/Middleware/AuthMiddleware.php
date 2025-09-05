<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Checa se existe token na sessão
            if (!$request->hasSession() || !$request->session()->has('jwt_token')) {
                return redirect()->route('login')->withErrors(['msg' => 'Usuário não autenticado'])->withInput();
            }
            $token = $request->session()->get('jwt_token');
            if (!$token) {
                return redirect()->route('login')->withErrors(['msg' => 'Token inválido'])->withInput();
            }
            $user = null;
            try {
                $user = JWTAuth::setToken($token)->authenticate();
            } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return redirect()->route('login')->withErrors(['msg' => 'Token expirado'])->withInput();
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return redirect()->route('login')->withErrors(['msg' => 'Token inválido'])->withInput();
            }
            if (!$user) {
                return redirect()->route('login')->withErrors(['msg' => 'Usuário não encontrado'])->withInput();
            }
            // Injeta usuário no request para usar nos controllers
            $request->attributes->set('jwt_user', $user);

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors('Erro desconhecido');
        }
        return $next($request);
    }
}
