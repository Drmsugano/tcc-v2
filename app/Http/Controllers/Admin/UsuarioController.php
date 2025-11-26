<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
use App\Models\Empresa;
use App\Models\Permissao;
use App\Models\Usuario;
use Exception;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
class UsuarioController extends Controller
{
    public function meuPerfil(Request $request)
    {
        $usuario = Usuario::where('ID', $request->user()->ID)
            ->with(['empresa:ID,NOME_FANTASIA', 'permissoes'])
            ->first();
        if (!$usuario) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado');
        }
        return view('Perfil.index', compact('usuario'));
    }
    public function index(Request $request)
    {
        $empresa = Empresa::where("ID", $request->user()->EMPRESA_ID)->first();
        $listaUsuarios = Usuario::with(["empresa", "permissoes"])->where("EMPRESA_ID", $empresa->ID)->get();
        $permissao = Permissao::select('PUBLIC_ID', 'NOME_PERMISSAO')->get();
        return view("Admin.Usuario.index", compact("empresa", "listaUsuarios", "permissao"));
    }
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'NOME' => 'required|string|max:255',
            'USUARIO' => 'required|string|max:255|unique:USUARIOS,USUARIO',
            'EMAIL' => 'required|email|max:255|unique:USUARIOS,EMAIL',
            'SENHA' => 'required|string|min:8',
            'permissoes' => 'required|array',
            'permissoes.*' => 'uuid|exists:PERMISSOES,PUBLIC_ID'
        ], [
            'NOME.required' => 'O nome completo do usuário não foi digitado',
            'EMAIL.required' => 'O email não foi informado',
            'EMAIL.unique' => 'O email informado já foi encontrado na base de dados',
            'USUARIO.required' => 'O usuário não foi informado',
            'USUARIO.unique' => 'O usuário informado já foi encontrado na base de dados',
            'SENHA.required' => 'A senha não foi informada',
            'SENHA.min' => 'A senha deve ter no mínimo 8 caracteres',
            'permissoes.required' => 'As permissões não foram informadas',
            'permissoes.*.uuid' => 'ID de permissão inválido',
            'permissoes.*.exists' => 'Permissão não encontrada na base de dados'
        ]);
        if ($data->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $data->errors(),
                'status' => 422
            ]);
        }
        $validos = $data->validated();
        $validos['PASSWORD'] = Hash::make($validos['SENHA']);
        $validos['EMPRESA_ID'] = $request->user()->EMPRESA_ID;
        $validos['PUBLIC_ID'] = Str::uuid();
        unset($validos['SENHA']); // tira a sujeira
        // 'permissoes' não vai pro create mesmo, então pode deixar fora
        try {
            if (Usuario::where('USUARIO', $validos['USUARIO'])->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Já existe um usuário com esse nome de usuário.',
                    'status' => 422
                ]);
            }
            if ($this->enviarEmailValidacao($validos['NOME'], $validos['EMAIL']) === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao enviar email de validação. Verifique as configurações de email do sistema.',
                    'status' => 500
                ]);
            } else {
                $usuario = Usuario::create($validos);
                $permissoesId = Permissao::whereIn('PUBLIC_ID', $request->input('permissoes', []))
                    ->pluck('ID')
                    ->toArray();
                $usuario->permissoes()->sync($permissoesId);
                return response()->json([
                    'success' => true,
                    'message' => 'Usuário cadastrado com sucesso!',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar usuário: ' . $e->getMessage(),
                'status' => 500
            ]);
        }
    }

    public function update(Request $request)
    {
        try {
            $usuario = Usuario::where('PUBLIC_ID', $request->PUBLIC_ID)->first();
            if (!$usuario) {
                return response()->json([
                    'status' => "Erro",
                    'mensagem' => "Usuário não encontrado",
                ], 404);
            }
            $validate = Validator::make($request->all(), [
                'NOME' => 'required|string|max:255',
                'USUARIO' => 'required|string|max:255|unique:USUARIOS,USUARIO,' . $usuario->ID,
                'EMAIL' => 'required|email|max:255|unique:USUARIOS,EMAIL,' . $usuario->ID,
                'SENHA' => 'nullable|string|min:8',
                'permissoes' => 'required|array',
                'permissoes.*' => 'integer|exists:PERMISSOES,ID'
            ], [
                'NOME.required' => 'O nome completo do usuário não foi digitado',
                'EMAIL.required' => 'O email não foi informado',
                'EMAIL.unique' => 'O email informado já foi encontrado na base de dados',
                'USUARIO.required' => 'O usuário não foi informado',
                'USUARIO.unique' => 'O usuário informado já foi encontrado na base de dados',
                'SENHA.min' => 'A senha deve ter no mínimo 8 caracteres',
                'permissoes.required' => 'As permissões não foram informadas',
                'permissoes.*.integer' => 'ID de permissão inválido',
                'permissoes.*.exists' => 'Permissão não encontrada na base de dados'
            ]
        );
            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validate->errors(),
                    'status' => 422
                ]);
            }
            $data = $validate->validated();
            // Atualizar senha se enviada
            if (!empty($data['SENHA'])) {
                $data['PASSWORD'] = Hash::make($data['SENHA']);
            }
            unset($data['SENHA']);

            if ($request->input('EMAIL') !== $usuario->EMAIL) {
                $data['EMAIL_VERIFICADO'] = false;
            }
            // Atualizar usuário
            $usuario->update(array_merge($data));
            // Atualizar permissões
            if (isset($data['permissoes'])) {
                $usuario->permissoes()->sync($data['permissoes']);
            }
            return response()->json([
                'success' => true,
                'message' => "Usuário atualizado com sucesso",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'mensagem' => "Erro de Servidor: " . $e->getMessage(),
            ], 500);
        }
    }


    public function desativarAtivar($id, Request $request)
    {
        try {
            $usuario = Usuario::where('PUBLIC_ID', $id)->first();
            if (!$usuario) {
                return response()->json([
                    'status' => "Erro",
                    "mensagem" => "Usuário não encontrado",
                ], 500);
            }
            if ($usuario->ID == $request->user()->ID) {
                return response()->json([
                    'status' => "Erro",
                    "mensagem" => "Você não pode desativar seu próprio usuário",
                ], 400);
            }
            $usuario->IS_DELETED = !$usuario->IS_DELETED;
            $usuario->save();
            return redirect()->route('admin.usuarios');
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                "message" => "Erro de Servidor: " . $e->getMessage(),
            ], 500);
        }
    }
    public function editar(Request $request, $id)
    {
        try {
            $empresa = Empresa::where("ID", $request->user()->EMPRESA_ID)->first();
            $usuario = Usuario::where('PUBLIC_ID', $id)
                ->with(['empresa:ID,NOME_FANTASIA', 'permissoes'])
                ->first();
            $permissao = Permissao::select('ID', 'PUBLIC_ID', 'NOME_PERMISSAO')->get();
            if (!$usuario) {
                return response()->json([
                    'status' => "Erro",
                    "mensagem" => "Usuário não encontrado",
                ], 500);
            }
            return view('Admin.Usuario.edit', compact('usuario', 'empresa', 'permissao'));
        } catch (Exception $e) {
            return response()->json([
                'status' => "Erro",
                "mensagem" => "Erro de Servidor: " . $e->getMessage(),
            ], 500);
        }
    }


    public function getDados(Request $request)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $query = Usuario::select(['PUBLIC_ID', 'NOME', 'USUARIO', 'IS_DELETED']);
        $query->when(
            $filtros['NOME'] ?? null,
            fn($q, $v) =>
            $q->where('NOME', 'like', "%" . trim($v) . "%")
        );
        $query->when(
            ($filtros['STATUS'] ?? null) === 'DESATIVADO',
            fn($q) =>
            $q->where('IS_DELETED', 1)
        );
        $query->when(
            ($filtros['STATUS'] ?? null) === 'ATIVOS',
            fn($q) =>
            $q->where('IS_DELETED', 0)
        );
        $query->when(
            $filtros['dataInicio'] ?? null,
            fn($q, $v) =>
            $q->where('DATA_CADASTRO', '>=', $v)
        );
        $usuarios = $query->paginate($perPage, ['*'], 'page', $page);
        $dados = $usuarios->map(function ($m) {
            return [
                'ID' => $m->PUBLIC_ID,
                'NOME' => $m->NOME,
                'USUARIO' => $m->USUARIO,
                'STATUS' => $m->IS_DELETED == 1 ? 'DESATIVADO' : 'ATIVO',
                'tabela' => 'usuario'
            ];
        });
        return response()->json([
            'data' => $dados,
            'tabela' => 'usuarioTable',
            'current_page' => $usuarios->currentPage(),
            'last_page' => $usuarios->lastPage(),
            'per_page' => $usuarios->perPage(),
            'total' => $usuarios->total(),
            'links' => $usuarios->linkCollection()->all(),
        ]);
    }
    public function enviarEmailValidacao($nome, $email)
    {
        try {
            Mail::to($email)->send(new \App\Mail\Validacao($nome, $email));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function reenviarEmail(Request $request)
    {
        $email = $request->query('email');
        $usuario = Usuario::where('EMAIL', $email)->first();
        if ($usuario) {
            if ($this->enviarEmailValidacao($usuario->NOME, $usuario->EMAIL)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Email de validação reenviado com sucesso!',
                ]);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Erro ao reenviar email de validação.',
        ]);
    }
    public function validarEmail(Request $request)
    {
        $email = $request->query('email');
        $usuario = Usuario::where('EMAIL', $email)->first();
        if ($usuario) {
            Usuario::where('EMAIL', $email)->update(['EMAIL_VERIFICADO' => true]);
            return view('mail.sucesso');
        }
        return view('mail.erro');
    }
}