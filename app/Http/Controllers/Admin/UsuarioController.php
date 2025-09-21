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
    public function store(UsuarioRequest $request)
    {
        $data = $request->validated();
        $data['PASSWORD'] = Hash::make($data['SENHA']);
        $data['EMPRESA_ID'] = $request->user()->EMPRESA_ID;
        $data['PUBLIC_ID'] = Str::uuid();
        unset($data['SENHA'], $data['permissoes']);
        try {
            // Cria o usuário
            $usuario = Usuario::create($data);
            // Relaciona permissões
            $permissoesId = Permissao::whereIn('PUBLIC_ID', $request->input('permissoes', []))
                ->pluck('ID')
                ->toArray();
            $usuario->permissoes()->sync($permissoesId);
            return redirect()->route('admin.usuarios')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {
            return redirect()->route('admin.usuarios')
                ->with(['error' => 'Erro ao cadastrar usuário: ' . $e->getMessage()])
                ->withInput();
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

}