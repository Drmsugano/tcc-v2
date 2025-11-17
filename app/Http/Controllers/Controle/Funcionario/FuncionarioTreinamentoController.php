<?php
namespace App\Http\Controllers\Controle\Funcionario;
use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\FuncionarioTreinamento;
use App\Models\Treinamento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FuncionarioTreinamentoController extends Controller
{
    public function index($id)
    {
        $funcionario = Funcionario::where('PUBLIC_ID', $id)->first();
        $treinamentos = Treinamento::where('EMPRESA_ID', $funcionario->EMPRESA_ID)->get();
        return view('Controle.Funcionario.Treinamentos.index', compact('funcionario', 'treinamentos'));
    }

    public function gerarProtocolo(Request $request)
    {
        $id = $request->query('id');
        $funcionarioTreinamento = FuncionarioTreinamento::where('ID', $id)->first();
        if (!$funcionarioTreinamento) {
            return response()->json(['success' => false, 'message' => 'Treinamento não encontrado.'], 404);
        }
        $funcionario = Funcionario::where('ID', $funcionarioTreinamento->FUNCIONARIO_ID)->first();
        $empresa = Empresa::where('ID', $funcionario->EMPRESA_ID)->first();
        $usuarioResponsavel = Usuario::where('ID', $funcionarioTreinamento->RESPONSAVEL)->first();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('Controle.Funcionario.Treinamentos.protocolo', [
            'funcionarioTreinamento' => $funcionarioTreinamento,
            'funcionario' => $funcionario,
            'empresa' => $empresa,
            'usuarioResponsavel' => $usuarioResponsavel,
        ]);
        return $pdf->stream('Protocolo_Treinamento_' . $funcionario->NOME . '.pdf');
    }


    public function getDados(Request $request, $id)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $funcionarioId = Funcionario::where('PUBLIC_ID', $id)->value('ID');
        $query = FuncionarioTreinamento::select([
            'FUNCIONARIO_TREINAMENTO.ID',
            'TREINAMENTOS.NOME AS NOME_TREINAMENTO',
            'FUNCIONARIO_TREINAMENTO.DATA_REALIZACAO AS DATA_TREINAMENTO',
            'FUNCIONARIO_TREINAMENTO.DATA_VALIDADE AS DATA_VALIDADE',
            'USUARIOS.NOME AS USUARIO_CADASTRO',
        ])->join('TREINAMENTOS', 'FUNCIONARIO_TREINAMENTO.TREINAMENTO_ID', '=', 'TREINAMENTOS.ID')
        ->join('USUARIOS', 'FUNCIONARIO_TREINAMENTO.RESPONSAVEL', '=', 'USUARIOS.ID')
            ->where('FUNCIONARIO_TREINAMENTO.FUNCIONARIO_ID', $funcionarioId);
        if (!empty($filtros['filtroNome'])) {
            $query->where('TREINAMENTOS.ID', $filtros['filtroNome']);
        }
        if (!empty($filtros['filtroData'])) {
            $query->whereDate('FUNCIONARIO_TREINAMENTO.DATA_REALIZACAO', $filtros['filtroData']);
        }
        if (isset($filtros['filtroStatus']) && $filtros['filtroStatus'] !== '') {
            if ($filtros['filtroStatus'] == 1) {
                $query->whereDate('FUNCIONARIO_TREINAMENTO.DATA_VALIDADE', '>=', now()->toDateString());
            } else {
                $query->whereDate('FUNCIONARIO_TREINAMENTO.DATA_VALIDADE', '<', now()->toDateString());
            }
        }
        $funcionarios = $query->paginate($perPage, ['*'], 'page', $page);
        $dados = $funcionarios->map(function ($item) {
            return [
                'ID' => $item->ID,
                'NOME_TREINAMENTO' => $item->NOME_TREINAMENTO,
                'DATA_TREINAMENTO' => date('d/m/Y', strtotime($item->DATA_TREINAMENTO)),
                'DATA_VALIDADE' => date('d/m/Y', strtotime($item->DATA_VALIDADE)),
                'USUARIO_CADASTRO' => $item->USUARIO_CADASTRO, 
                'STATUS' => (strtotime($item->DATA_VALIDADE) >= strtotime(now()->toDateString())) ? 'Ativo' : 'Vencido',
            ];
        });
        return response()->json([
            'data' => $dados,
            'tabela' => 'funcionarioTreinamentoTable',
            'current_page' => $funcionarios->currentPage(),
            'last_page' => $funcionarios->lastPage(),
            'per_page' => $funcionarios->perPage(),
            'total' => $funcionarios->total(),
            'links' => $funcionarios->linkCollection()->all(),
        ]);
    }
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'funcionario_id' => 'required|exists:FUNCIONARIOS,ID',
                'treinamento' => 'required|exists:TREINAMENTOS,ID',
                'dataTreinamento' => 'required|date',
            ], [
                'funcionario_id.required' => 'O campo Funcionário é obrigatório.',
                'funcionario_id.exists' => 'O funcionário selecionado não existe.',
                'treinamento.required' => 'O campo Treinamento é obrigatório.',
                'treinamento.exists' => 'O treinamento selecionado não existe.',
                'dataTreinamento.required' => 'O campo Data do Treinamento é obrigatório.',
                'dataTreinamento.date' => 'O campo Data do Treinamento deve ser uma data válida.',
            ]);
            if ($validate->fails()) {
                return response()->json(['success' => false, 'errors' => $validate->errors(), 'status' => 422]);
            }
            $validade = date('Y-m-d', strtotime($request->input('dataTreinamento') . " + " . Treinamento::where('ID', $request->input('treinamento'))->value('VALIDADE_MESES') . " months"));
            FuncionarioTreinamento::insert([
                'FUNCIONARIO_ID' => $request->input('funcionario_id'),
                'TREINAMENTO_ID' => $request->input('treinamento'),
                'DATA_REALIZACAO' => $request->input('dataTreinamento'),
                'DATA_VALIDADE' => $validade,
                'RESPONSAVEL' => $request->user()->ID,
            ]);
            return response()->json(['success' => true, 'message' => 'Treinamento cadastrado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao cadastrar o treinamento: ' . $e->getMessage()], 500);
        }
    }
}