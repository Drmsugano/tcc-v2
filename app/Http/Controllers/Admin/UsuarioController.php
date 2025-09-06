<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $empresa = Empresa::where("ID", $request->user()->EMPRESA_ID)->first();
        $listaUsuarios = Usuario::where("EMPRESA_ID", $request->user()->EMPRESA_ID)->get();
        return view("Admin.usuario.index", compact("empresa", "listaUsuarios"));
    }
    public function store(Request $request)
    {
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
            $permissoes = $data['permissoes'];
            $data['PASSWORD'] = Hash::make($data['SENHA']);
            $data['EMPRESA_ID'] = $request->user()->EMPRESA_ID;
            unset($data['permissoes'], $data['SENHA']);
            $usuario = Usuario::create(array_merge($data, $permissoes));
            foreach ($permissoes as $perm) {
                $usuario->$perm = 1;
            }
            $usuario->save();
            return back()->with('success', 'Usuário cadastrado com sucesso!');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function getDados(Request $request)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $query = Usuario::select(['ID', 'NOME','USUARIO', 'IS_DELETED']);
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
                'ID' => $m->ID,
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