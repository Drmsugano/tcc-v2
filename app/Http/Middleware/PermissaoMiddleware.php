<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        try {
            $usuario = $request->attributes->get('jwt_user');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors('Usuário não Autenticado');
        }
        // Admin ou Master tem acesso a tudo
        $userPermissoes = collect($usuario->permissoesArray()); // array de nomes de permissões
        if ($userPermissoes->contains('ADMIN') || $userPermissoes->contains('MASTER')) {
            return $next($request);
        }
        // Divide permissões passadas no middleware por vírgula
        $permissaoList = array_map('trim', explode(',', $permissoes));
        // Verifica se o usuário tem pelo menos uma permissão necessária
        $hasPermission = false;
        foreach ($permissaoList as $perm) {
            if ($userPermissoes->contains(strtoupper($perm))) {
                $hasPermission = true;
                break;
            }
        }
        if (!$hasPermission) {
            return redirect()->route('home')
                ->withErrors('Usuário não possui permissão para esta tela! Contate o Administrador do Sistema');
        }
        return $next($request);
    }
}
