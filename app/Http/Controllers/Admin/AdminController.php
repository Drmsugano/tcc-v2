<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
class AdminController extends Controller
{
    public function index(Request $request)
    {
        $empresa = Empresa::where("ID", $request->user()->EMPRESA_ID)->first();
        $listaUsuarios = Usuario::where("EMPRESA_ID", $request->user()->EMPRESA_ID)->get();
        return view("Admin.index", compact("empresa", "listaUsuarios"));
    }
    public function store(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'NOME' => 'required|string|max:255',
            'USUARIO' => 'required|string|max:255|unique:USUARIOS,USUARIO',
            'EMAIL' => 'required|email|max:255|unique:USUARIOS,EMAIL',
            'SENHA' => 'required|string|min:1',
            'permissoes' => 'required|array',
            'permissoes.*' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        try {
            $data = $validator->validated();
            // Hash da senha
            $data['SENHA'] = Hash::make($data['SENHA']);
            // Adiciona EMPRESA_ID
            $data['EMPRESA_ID'] = $request->user()->EMPRESA_ID;
            // Salva usuário
            $usuario = Usuario::insert($data);
            // Salva permissões (transforma array em campos ROSFIELD)
            foreach ($data['permissoes'] as $perm) {
                $usuario->$perm = 1; // ex: ROSFIELD_ADMIN = 1
            }
            $usuario->save();
            return back()->with('success', 'Usuário cadastrado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}