<?php
namespace App\Http\Controllers\Controle\Funcionario;
use App\Http\Controllers\Controller;
use App\Models\Funcao;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FuncionarioController extends Controller
{
    public function index()
    {
        $funcao = Funcao::all();
        return view('Controle.Funcionario.index', compact('funcao'));
    }

    public function getDados(Request $request)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $funcionarios = Funcionario::select(['FUNCIONARIOS.PUBLIC_ID as ID', 'FUNCIONARIOS.NOME AS NOME_FUNCIONARIO', 'DATA_ADMISSAO'])->join('FUNCAO', 'FUNCAO.ID', '=', 'FUNCIONARIOS.FUNCAO_ID')->addSelect('FUNCAO.NOME as FUNCAO');
        $funcionarios->when($filtros['filtroFuncionario'] ?? null, function ($q, $nome) {
            $q->where('FUNCIONARIOS.NOME', 'like', '%' . $nome . '%');
        });
        $funcionarios->where('FUNCIONARIOS.EMPRESA_ID', $request->user()->EMPRESA_ID);
        $funcionarios = $funcionarios->paginate($perPage, ['*'], 'page', $page);
        $dados = $funcionarios->map(function ($item) {
            return [
                'ID' => $item->ID,
                'NOME_FUNCIONARIO' => $item->NOME_FUNCIONARIO,
                'DATA_ADMISSAO' => date('d/m/Y', strtotime($item->DATA_ADMISSAO)),
                'FUNCAO' => $item->FUNCAO,
                'tabela' => 'funcionarioTable',
            ];
        });
        return response()->json([
            'data' => $dados,
            'tabela' => 'funcionarioTable',
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
                'nomeFuncionario' => 'required|string|max:255',
                'cpfFuncionario' => 'required|string|max:14|unique:FUNCIONARIOS,CPF',
                'pis' => 'required|string|max:14',
                'dataAdmissao' => 'required|date|after_or_equal:today',
                'funcaoFuncionario' => 'required|exists:FUNCAO,ID',
            ],
        [
                'nomeFuncionario.required' => 'O campo Nome do Funcionário é obrigatório.',
                'cpfFuncionario.required' => 'O campo CPF é obrigatório.',
                'pis.required' => 'O campo PIS é obrigatório.',
                'dataAdmissao.required' => 'O campo Data de Admissão é obrigatório.',
                'dataAdmissao.after_or_equal' => 'A Data de Admissão não pode ser anterior a hoje.',
                'funcaoFuncionario.required' => 'O campo Função é obrigatório.',
                'funcaoFuncionario.exists' => 'A função selecionada é inválida.',
        ]);
            if ($validate->fails()) {
                return response()->json(['success' => false, 'errors' => $validate->errors(), 'status' => 422]);
            }
            Funcionario::insert([
                'NOME' => $request->input('nomeFuncionario'),
                'CPF' => $request->input('cpfFuncionario'),
                'PIS' => $request->input('pis'),
                'DATA_ADMISSAO' => $request->input('dataAdmissao'),
                'EMPRESA_ID' => $request->user()->EMPRESA_ID,
                'FUNCAO_ID' => $request->input('funcaoFuncionario'),
                'PUBLIC_ID' => \Illuminate\Support\Str::uuid(),
            ]);
            return response()->json(['success' => true, 'message' => 'Funcionário cadastrado com sucesso!'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao cadastrar funcionário: ' . $e->getMessage()], 500);
        }
    }
    public function show($id)
    {
        $funcionario = Funcionario::where('PUBLIC_ID', $id)->with(['funcao','empresa'])->first();
        if (!$funcionario) {
            return response()->json(['success' => false, 'message' => 'Funcionário não encontrado.'], 404);
        }
        return response()->json(['success' => true, 'data' => $funcionario], 200);
    }
    public function update(Request $request)
    {
        //
    }
}