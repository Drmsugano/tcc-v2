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
        // Inicializa variáveis
        $usuarioView = [];
        $obras = collect();

        // Verifica se existe token JWT na sessão
        if ($request->hasSession() && $request->session()->has('jwt_token')) {
            $token = $request->session()->get('jwt_token');

            try {
                // Autentica o usuário
                $usuario = JWTAuth::setToken($token)->authenticate();

                if ($usuario) {
                    // Todas as obras da empresa como Collection
                    $obras = Obra::where('EMPRESA_ID', $usuario->empresa->ID)->get();

                    // Obra atual da sessão
                    $obraAtualId = $request->session()->get('obra_id');
                    $obraAtualObj = $obraAtualId ? Obra::find($obraAtualId) : null;

                    // Monta array do usuário
                    $usuarioView = [
                        'ID'              => $usuario->ID,
                        'NOME'            => $usuario->NOME,
                        'USUARIO'         => $usuario->USUARIO,
                        'PERMISSOES'      => $usuario->permissoesArray(),
                        'EMPRESA'         => $usuario->empresa->NOME_FANTASIA ?? null,
                        'OBRA_ATUAL'      => $obraAtualObj?->ID,
                        'OBRA_ATUAL_NOME' => $obraAtualObj?->NOME_OBRA,
                    ];
                }
            } catch (\Exception $e) {
                // Loga erro e mantém valores padrão
                Log::error('Erro no InjectUserView: ' . $e->getMessage());
                $usuarioView = [];
                $obras = collect();
            }
        }

        // Proteção extra: garante que $obras é Collection
        if (!($obras instanceof \Illuminate\Support\Collection)) {
            $obras = collect();
        }

        // Compartilha com todas as views
        view()->share([
            'usuarioView' => $usuarioView,
            'obras'       => $obras,
        ]);

        return $next($request);
    }
}
