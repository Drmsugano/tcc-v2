<?php
namespace App\Http\Middleware;

use App\Models\Obra;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class InjectUserView
{
    public function handle(Request $request, Closure $next)
    {
        $usuarioView = [];
        $obras = collect(); // sempre inicia como Collection

        if ($request->hasSession() && $request->session()->has('jwt_token')) {
            $token = $request->session()->get('jwt_token');

            try {
                // Autentica usuário
                $usuario = JWTAuth::setToken($token)->authenticate();

                if ($usuario) {
                    // Garante que a empresa existe
                    if ($usuario->empresa) {
                        $obras = Obra::where('EMPRESA_ID', $usuario->empresa->ID)->get();
                    }

                    // Obra atual da sessão
                    $obraAtualId = $request->session()->get('obra_id');
                    $obraAtualObj = $obraAtualId ? Obra::where('PUBLIC_ID', $obraAtualId)->first() : null;

                    // Monta array do usuário
                    $usuarioView = [
                        'ID' => $usuario->ID,
                        'NOME' => $usuario->NOME,
                        'USUARIO' => $usuario->USUARIO,
                        'PERMISSOES' => $usuario->permissoesArray(),
                        'EMPRESA' => $usuario->empresa->NOME_FANTASIA ?? null,
                        'OBRA_ATUAL' => $obraAtualObj?->PUBLIC_ID,
                        'OBRA_ATUAL_NOME' => $obraAtualObj?->NOME_OBRA,
                    ];
                }
            } catch (\Exception $e) {
                Log::error('Erro no InjectUserView: ' . $e->getMessage());
            }
        }

        // Proteção extra: garante que $obras seja sempre Collection
        if (!($obras instanceof \Illuminate\Support\Collection)) {
            $obras = collect();
        }

        view()->share([
            'usuarioView' => $usuarioView,
            'obrasSelect' => $obras,
        ]);

        return $next($request);
    }
}
