<?php
namespace App\Http\Controllers\Controle\Funcionario;
use App\Http\Controllers\Controller;
use App\Models\Funcao;
use App\Models\FuncionarioObra;
use App\Models\Obra;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class FuncionarioObraController extends Controller
{
    public function index($id)
    {
        $obra = Obra::where('PUBLIC_ID', $id)->with('funcionarios')->first();
        $funcionarios = Funcionario::where('EMPRESA_ID', $obra->EMPRESA_ID)->get();
        $funcoes = Funcao::where('EMPRESA_ID', $obra->EMPRESA_ID)->get();
        return view('Controle.Obras.Funcionario.index', compact('obra', 'funcionarios', 'funcoes'));
    }
    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'funcionario' => 'required|exists:FUNCIONARIOS,ID'
        ], [
            'funcionario.required' => 'O campo Funcionário é obrigatório.',
            'funcionario.exists' => 'O funcionário selecionado não existe.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(), 'status' => 422]);
        }
        $obraId = Obra::where('PUBLIC_ID', $id)->value('ID');
        $funcionarioObra = FuncionarioObra::where('OBRA_ID', $obraId)
            ->where('FUNCIONARIO_ID', $request->input('funcionario'))
            ->first();
        if ($funcionarioObra) {
            if ($funcionarioObra->DATA_FIM === null) {
                return response()->json(['success' => false, 'message' => 'Funcionário já está ativo na obra.'], 400);
            } else {
                $funcionarioObra->update([
                    'DATA_INICIO' => now()->toDateString(),
                    'DATA_FIM' => null,
                ]);
                return response()->json(['success' => true, 'message' => 'Funcionário reativado na obra com sucesso.']);
            }
        } else {
            FuncionarioObra::create([
                'OBRA_ID' => $obraId,
                'FUNCIONARIO_ID' => $request->input('funcionario'),
                'DATA_INICIO' => now()->toDateString(),
            ]);
            return response()->json(['success' => true, 'message' => 'Funcionário adicionado à obra com sucesso.']);
        }
    }
    public function getDados(Request $request, $id)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $obraId = Obra::where('PUBLIC_ID', $id)->value('ID');
        $query = FuncionarioObra::select([
            'FUNCIONARIO_OBRA.ID',
            'FUNCAO.ID AS FUNCAO_ID',
            'FUNCIONARIOS.NOME AS NOME_FUNCIONARIO',
            'FUNCAO.NOME AS FUNCAO',
            'DATA_INICIO',
            'DATA_FIM'
        ])
            ->join('FUNCIONARIOS', 'FUNCIONARIOS.ID', '=', 'FUNCIONARIO_OBRA.FUNCIONARIO_ID')
            ->join('FUNCAO', 'FUNCAO.ID', '=', 'FUNCIONARIOS.FUNCAO_ID')
            ->where('FUNCIONARIO_OBRA.OBRA_ID', $obraId);
        $query->when($filtros['nomeFuncionario'] ?? null, function ($q, $nome) {
            $q->where('FUNCIONARIOS.NOME', 'like', '%' . $nome . '%');
        });
        $query->when(isset($filtros['funcaoFuncionario']) && $filtros['funcaoFuncionario'] !== '', function ($q) use ($filtros) {
            $q->where('FUNCAO_ID', $filtros['funcaoFuncionario']);
        });
        $query->when(isset($filtros['statusFuncionario']) && $filtros['statusFuncionario'] !== '', function ($q) use ($filtros) {
            if ($filtros['statusFuncionario'] == 'ATIVO') {
                $q->whereNull('FUNCIONARIO_OBRA.DATA_FIM');
            } elseif ($filtros['statusFuncionario'] == 'INATIVO') {
                $q->whereNotNull('FUNCIONARIO_OBRA.DATA_FIM');
            }
        });
        $funcionarios = $query->paginate($perPage, ['*'], 'page', $page);
        $dados = $funcionarios->map(function ($item) {
            return [
                'ID' => $item->ID,
                'NOME_FUNCIONARIO' => $item->NOME_FUNCIONARIO,
                'STATUS' => $item->DATA_FIM ? 'INATIVO' : 'ATIVO',
                'DATA_INICIO' => date('d/m/Y', strtotime($item->DATA_INICIO)),
                'DATA_FIM' => $item->DATA_FIM
                    ? date('d/m/Y', strtotime($item->DATA_FIM))
                    : null, // Ou "Em andamento"
                'FUNCAO' => $item->FUNCAO,
                'tabela' => 'funcionarioObraTable',
            ];
        });

        return response()->json([
            'data' => $dados,
            'tabela' => 'funcionarioObraTable',
            'current_page' => $funcionarios->currentPage(),
            'last_page' => $funcionarios->lastPage(),
            'per_page' => $funcionarios->perPage(),
            'total' => $funcionarios->total(),
            'links' => $funcionarios->linkCollection()->all(),
        ]);
    }
    public function destroy(Request $request, $id)
    {
        $funcionarioId = $request->query('funcionarioId');
        $funcionarioObra = FuncionarioObra::find($funcionarioId);
        if (!$funcionarioObra) {
            return response()->json(['message' => 'Funcionário na obra não encontrado.'], 404);
        }
        if ($funcionarioObra->DATA_FIM !== null) {
            $funcionarioObra->update(['DATA_FIM' => null]);
            return response()->json(['success' => true, 'message' => 'Funcionário já foi removido da obra.'], 400);
        } else {
            $funcionarioObra->update(['DATA_FIM' => now()->toDateString()]);
            return response()->json(['success' => true, 'message' => 'Funcionário removido da obra com sucesso.']);
        }
    }
}