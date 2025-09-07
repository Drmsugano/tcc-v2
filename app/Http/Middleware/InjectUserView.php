<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Log\Logger;

class InjectUserView
{
    public function handle(Request $request, Closure $next)
    {
        $usuarioView = null;

        if ($request->hasSession() && $request->session()->has('jwt_token')) {
            $token = $request->session()->get('jwt_token');
            try {
                $usuario = JWTAuth::setToken($token)->authenticate();

                if ($usuario) {
                    $usuarioView = [
                        'ID' => $usuario->ID,
                        'NOME' => $usuario->NOME,
                        'USUARIO' => $usuario->USUARIO,
                        'PERMISSOES' => $usuario->permissoesArray(),
                        'EMPRESA' => $usuario->empresa->NOME_FANTASIA ?? null,
                    ];
                }

            } catch (\Exception $e) {
                $usuarioView = null;
            }
        }

        view()->share('usuarioView', $usuarioView);

        return $next($request);
    }
}
