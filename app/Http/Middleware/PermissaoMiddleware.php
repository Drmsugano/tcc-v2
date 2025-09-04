<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissaoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permissoes  Permissões separadas por vírgula
     */
    public function handle(Request $request, Closure $next, string $permissoes): Response
    {
        $usuario = $request->attributes->get('jwt_user');

        if (!$usuario) {
            return redirect()->route('login')->withErrors('Usuário não Autenticado');
        }

        // Admin tem acesso a tudo
        if (isset($usuario['ROSFIELD_ADMIN']) && $usuario['ROSFIELD_ADMIN'] == 1) {
            return $next($request);
        }
        // Divide permissões por vírgula
        $permissaoList = array_map('trim', explode(',', $permissoes));
        // Verifica se o usuário tem pelo menos uma permissão
        $hasPermission = false;
        foreach ($permissaoList as $perm) {
            if (isset($usuario[$perm]) && $usuario[$perm] == 1) {
                $hasPermission = true;
                break;
            }
        }
        if (!$hasPermission) {
            return redirect()->route('home')->withErrors('Usuário não possui permissão para esta tela!! Contate o Administrador do Sistema');
        }
        return $next($request);
    }
}
