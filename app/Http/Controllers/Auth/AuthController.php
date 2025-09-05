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

        $usuario = Usuario::where('USUARIO', strtoupper($request->login))->first();

        if (!$usuario || !Hash::check($request->senha, $usuario->PASSWORD)) {
            session()->flush();
            return response()->json([
                'status' => 'error',
                'message' => 'Usuário ou senha incorretos.'
            ], 200);
        }

        // Claims customizadas com permissões
        $customClaims = [
            'ROSFIELD_ADMIN' => $usuario->ROSFIELD_ADMIN,
            'ROSFIELD_FINANCEIRO' => $usuario->ROSFIELD_FINANCEIRO,
            'ROSFIELD_CONTROLE' => $usuario->CONTROLE,
            'USUARIO' => $usuario->USUARIO
        ];

        $token = JWTAuth::claims($customClaims)->fromUser($usuario);
        $request->session()->put('jwt_token', $token);
        return response()->json([
            'status' => 'success',
            'message' => 'Login realizado com sucesso.',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'usuario' => $usuario->makeHidden(['PASSWORD', 'remember_token'])
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
            session()->forget('jwt_token');
            return redirect()->route('login');
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Erro ao fazer logout.'], 500);
        }
    }
}
