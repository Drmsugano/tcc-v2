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
            $token = isset($_COOKIE['jwt_token']) ? $_COOKIE['jwt_token'] : null; // Verifica se o cookie jwt_token existe
        }
        if (!$token) {
            return redirect()->route('login')->withErrors(['error' => 'Usuário não autenticado.']);
        }
        try {
            return view('home.index', ['usuario' => JWTAuth::setToken($token)->authenticate()]);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Token inválido ou expirado.']);
        }
    }

}
