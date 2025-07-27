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
            'login' => 'required|string',
            'senha' => 'required|string',
        ]);
        try {
            $usuario = Usuario::where('USUARIO', strtoupper($request->input('login')))->first();

            if (!$usuario) {
                return response()->json(['status' => 'error', 'message' => 'Usuário ou senha incorretos.'], 401);
            }

            if (!Hash::check($request->senha, $usuario->PASSWORD)) {
                return response()->json(['status' => 'error', 'message' => 'Usuário ou senha incorretos.'], 401);
            }

            // Gera o token JWT
            $token = JWTAuth::fromUser($usuario);

            if (!$token) {
                return response()->json(['error' => 'Erro ao gerar o token.'], 500);
            }
            // Esconde campos sensíveis
            $usuario->makeHidden(['password', 'remember_token']);
            // Define o token no cookie
            setcookie('jwt_token', $token, time() + (60 * 60), '/'); // 1 hora de expiração
            return response()->json([
                'message' => 'Login realizado com sucesso.',
                'status' => 'success',
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
                'usuario' => $usuario,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao processar a solicitação: ' . $e->getMessage()], 500);
        }
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
