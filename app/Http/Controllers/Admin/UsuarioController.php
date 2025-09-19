<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Permissao;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $empresa = Empresa::where("ID", $request->user()->EMPRESA_ID)->first();
        $listaUsuarios = Usuario::with(["empresa", "permissoes"])->where("EMPRESA_ID", $empresa->ID)->get();
        $permissao = Permissao::select('PUBLIC_ID', 'NOME_PERMISSAO')->get();
        return view("Admin.Usuario.index", compact("empresa", "listaUsuarios", "permissao"));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NOME' => 'required|string|max:255',
            'USUARIO' => 'required|string|max:255|unique:USUARIOS,USUARIO',
            'EMAIL' => 'required|email|max:255|unique:USUARIOS,EMAIL',
            'SENHA' => 'required|string|min:1',
            'permissoes' => 'required|array',
            'permissoes.*' => 'uuid|exists:PERMISSOES,PUBLIC_ID',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $validator->validated();
        $data['PASSWORD'] = Hash::make($data['SENHA']);
        $data['EMPRESA_ID'] = $request->user()->EMPRESA_ID;
        $data['PUBLIC_ID'] = Str::uuid();
        unset($data['SENHA'], $data['permissoes']);
        try {
            $usuario = Usuario::create($data);
            $permissoesId = Permissao::whereIn('PUBLIC_ID', $request->input('permissoes'))
                ->pluck('ID')
                ->toArray();
            $usuario->permissoes()->sync($permissoesId);
            return back()->with('success', 'Usuário cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['erro' => 'Erro ao cadastrar usuário: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function editar($id)
    {
        try {
            $usuario = Usuario::where('PUBLIC_ID', $id)
                ->with(['empresa:ID,NOME_FANTASIA', 'permissoes'])
                ->first();
            if (!$usuario) {
                return response()->json([
                    'status' => "Erro",
                    "mensagem" => "Usuário não encontrado",
                ], 500);
            }
            return response()->json([
                'status' => 'sucesso',
                'usuario' => $usuario
            ]);
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
            $q->where('NOME', 'like', "%$v%")
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

}