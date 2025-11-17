<?php
namespace App\Http\Controllers\Controle\Epi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Epi;
use App\Models\Fornecedor;

class EpiController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedor::select(['NOME_FORNECEDOR AS NOME', 'ID'])->where('IS_DELETED', 0)->get();
        return view('Controle.Epi.index', compact('fornecedores'));
    }
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|string',
                'nomeEPI' => 'required|string|max:255',
                'descricaoEPI' => 'nullable|string',
                'ca' => 'required|string|max:100',
                'dataValidadeMaterial' => 'required|date',
                'dataValidade' => 'required|date',
                'fornecedorEPI' => 'required|integer',
                'quantidadeEstoque' => 'required|integer|min:0',
            ]);
            if (date('Y-m-d') > $validatedData['dataValidade']) {
                return response()->json([
                    'success' => false,
                    'message' => 'A data de aquisição não pode ser maior que a data de validade.'
                ], 400);
            }
            if ($validatedData) {
                Epi::where('PUBLIC_ID', $validatedData['id'])->update([
                    'NOME' => $validatedData['nomeEPI'],
                    'DESCRICAO' => $validatedData['descricaoEPI'] ?? null,
                    'CA' => $validatedData['ca'],
                    'VALIDADE_EPI' => $validatedData['dataValidade'],
                    'VALIDADE_MATERIAL' => $validatedData['dataValidadeMaterial'],
                    'FORNECEDOR_ID' => $validatedData['fornecedorEPI'],
                    'USUARIO_ALTERACAO' => $request->user()->ID,
                    'EMPRESA_ID' => $request->user()->EMPRESA_ID,
                    'QUANTIDADE_ESTOQUE' => $validatedData['quantidadeEstoque'],
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'EPI atualizado com sucesso.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos fornecidos.'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao atualizar o EPI: ' . $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nomeEpi' => 'required|string|max:255',
                'descricaoEpi' => 'nullable|string',
                'ca' => 'required|string|max:100|unique:EPI,CA',
                'dataValidade' => 'required|date',
                'dataMaterial' => 'required|date',
                'fornecedorEPI' => 'required|integer',
                'quantidadeEPI' => 'required|integer|min:0',
            ]);
            if (date('Y-m-d') > $validatedData['dataValidade']) {
                return response()->json([
                    'success' => false,
                    'message' => 'A data de aquisição não pode ser maior que a data de validade.'
                ], 400);
            }
            if ($validatedData) {
                Epi::insert([
                    'NOME' => $validatedData['nomeEpi'],
                    'DESCRICAO' => $validatedData['descricaoEpi'] ?? null,
                    'CA' => $validatedData['ca'],
                    'VALIDADE_EPI' => $validatedData['dataValidade'],
                    'VALIDADE_MATERIAL' => $validatedData['dataMaterial'],
                    'FORNECEDOR_ID' => $validatedData['fornecedorEPI'],
                    'USUARIO_CADASTRO' => $request->user()->ID,
                    'EMPRESA_ID' => $request->user()->EMPRESA_ID,
                    'PUBLIC_ID' => \Illuminate\Support\Str::uuid(),
                    'QUANTIDADE_ESTOQUE' => $validatedData['quantidadeEPI'],
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'EPI cadastrado com sucesso.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos fornecidos.'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao cadastrar o EPI: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getDados(Request $request)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $query = Epi::select('PUBLIC_ID as ID', 'NOME', 'DESCRICAO', 'CA', 'QUANTIDADE_ESTOQUE','VALIDADE_EPI','VALIDADE_MATERIAL');
        $query->when($filtros['filtroEpi'] ?? null, fn($q, $v) => $q->where('CA', trim($v)));
        $epis = $query->paginate($perPage, ['*'], 'page', $page);
        $dados = $epis->map(function ($m) {
            return [
                'ID' => $m->ID,
                'CA' => $m->CA,
                'NOME' => $m->NOME,
                'DESCRICAO' => $m->DESCRICAO,
                'STATUS_EPI' => (date('Y-m-d') > $m->VALIDADE_EPI) ? 'Vencido' : 'Válido',
                'STATUS_MATERIAL' => (date('Y-m-d') > $m->VALIDADE_MATERIAL) ? 'Vencido' : 'Válido',
                'QUANTIDADE_ESTOQUE' => $m->QUANTIDADE_ESTOQUE,
                'tabela' => 'epi'
            ]
            ;
        });
        return response()->json([
            'data' => $dados,
            'tabela' => 'epiTable',
            'current_page' => $epis->currentPage(),
            'last_page' => $epis->lastPage(),
            'per_page' => $epis->perPage(),
            'total' => $epis->total(),
            'links' => $epis->linkCollection()->all(),
        ]);
    }
    public function getEpi($id)
    {
        $epi = Epi::where('PUBLIC_ID', $id)->first();
        $fornecedores = Fornecedor::select(['ID', 'NOME_FORNECEDOR'])->get();
        if (!$epi) {
            return redirect()->route('controle.epi')->with('error', 'EPI não encontrado.');
        }
        return view('Controle.Epi.detalhes', compact('epi', 'fornecedores'));
    }
}