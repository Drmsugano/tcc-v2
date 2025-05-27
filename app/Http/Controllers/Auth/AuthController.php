<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'senha' => 'required|string',
        ]);

        $usuario = Usuario::where('NOME', $request->usuario)->first();

        if (!$usuario) {
            return response()->json(['error' => 'Usuário não encontrado.'], 404);
        }

        if (!Hash::check($request->senha, $usuario->password)) {
            return response()->json(['error' => 'Senha incorreta.'], 401);
        }

        // Gera o token JWT
        $token = JWTAuth::fromUser($usuario);

        if (!$token) {
            return response()->json(['error' => 'Erro ao gerar o token.'], 500);
        }

        // Esconde campos sensíveis
        $usuario->makeHidden(['password', 'remember_token']);

        return response()->json([
            'message' => 'Login realizado com sucesso.',
            'status' => 'success',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'usuario' => $usuario,
        ], 200);
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60  // tempo de expiração em segundos
        ]);
    }


    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Logout realizado com sucesso.']);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Erro ao fazer logout.'], 500);
        }
    }
}
