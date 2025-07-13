<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Tenta pegar o token do header Authorization
        $token = $request->bearerToken();
        // Se não tiver no header, tenta no cookie (que você definiu no JS)
        if (!$token) {
            $token = $request->cookie('jwt_token');
        }
        dd($token);
        try {
            $usuario = JWTAuth::setToken($token)->authenticate();
            // $usuario válido - prossiga conforme o perfil
            switch ($usuario->PERFIL) {
                case 'ADMINISTRADOR':
                    return view('Admin.index', compact('usuario'));
                case 'FUNCIONARIO':
                    return view('Funcionario.index', compact('usuario'));
                case 'SEGURANCA DO TRABALHO':
                    return view('Seguranca.index', compact('usuario'));
                default:
                    return redirect()->route('login')->withErrors(['error' => 'Perfil não reconhecido.']);
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Token inválido ou expirado.']);
        }
    }

}
