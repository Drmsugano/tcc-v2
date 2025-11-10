<?php
namespace App\Http\Controllers\Controle\Fornecedor;
use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use App\Models\TipoFornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FornecedorController extends Controller
{
    public function index()
    {
        $tiposFornecedores = TipoFornecedor::all();
        return view('Controle.Fornecedor.index', compact('tiposFornecedores'));
    }

    public function getDados(Request $request)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $fornecedores = Fornecedor::select(['PUBLIC_ID as ID', 'NOME_FORNECEDOR', 'CNPJ', 'ESTADO', 'CIDADE','IS_DELETED'])->join('TIPO_FORNECEDOR', 'FORNECEDOR.TIPO_FORNECEDOR_ID', '=', 'TIPO_FORNECEDOR.ID')->addSelect('TIPO_FORNECEDOR.TIPO as TIPO_FORNECEDOR');
        $fornecedores->when($filtros['cnpj'] ?? null, function ($q, $cnpj) {
            $q->where('CNPJ', '=', $cnpj);
        });
        $fornecedores->when($filtros['nomeFornecedor'] ?? null, function ($q, $nome) {
            $q->where('NOME_FORNECEDOR', 'like', '%' . $nome . '%');
        });
        $fornecedores = $fornecedores->paginate($perPage, ['*'], 'page', $page);
        $dados = $fornecedores->map(function ($item) {
            return [
                'ID' => $item->ID,
                'NOME_FORNECEDOR' => $item->NOME_FORNECEDOR,
                'CNPJ' => $item->CNPJ,
                'STATUS' => $item->IS_DELETED == 1 ? 'Inativo' : 'Ativo',
                'TIPO_FORNECEDOR' => $item->TIPO_FORNECEDOR,
                'ESTADO' => $item->ESTADO,
                'CIDADE' => $item->CIDADE,
                'tabela' => 'fornecedorTable',
            ];
        });
        return response()->json([
            'data' => $dados,
            'tabela' => 'fornecedorTable',
            'current_page' => $fornecedores->currentPage(),
            'last_page' => $fornecedores->lastPage(),
            'per_page' => $fornecedores->perPage(),
            'total' => $fornecedores->total(),
            'links' => $fornecedores->linkCollection()->all(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nomeFornecedor' => 'required|string',
                'cidadeFornecedor' => 'nullable|string|max:100',
                'estadoFornecedor' => 'nullable|string|max:100',
                'CEP' => 'nullable|string|max:30',
                'enderecoFornecedor' => 'nullable|string',
                'cnpjFornecedor' => 'required|string',
                'tipoFornecedor' => 'required',
                'telefoneFornecedor' => 'nullable|string|max:40',
                'nomeResponsavel' => 'nullable|string',
                'descricaoFornecedor' => 'nullable|string|max:1000',
            ]);
            Fornecedor::insert([
                'NOME_FORNECEDOR' => $validatedData['nomeFornecedor'],
                'CNPJ' => $validatedData['cnpjFornecedor'],
                'TIPO_FORNECEDOR_ID' => $validatedData['tipoFornecedor'],
                'CEP' => $validatedData['CEP'] ?? null,
                'ENDERECO' => $validatedData['enderecoFornecedor'] ?? null,
                'CIDADE' => $validatedData['cidadeFornecedor'] ?? null,
                'ESTADO' => $validatedData['estadoFornecedor'] ?? null,
                'TELEFONE' => $validatedData['telefoneFornecedor'] ?? null,
                'VENDEDOR' => $validatedData['nomeResponsavel'] ?? null,
                'USUARIO_CADASTRO' => $request->user()->ID,
                'OBSERVACAO' => $validatedData['descricaoFornecedor'] ?? null,
                'PUBLIC_ID' => \Illuminate\Support\Str::uuid(),
            ]);
            return response()->json(
                ['success' => true, 'message' => 'Fornecedor cadastrado com sucesso.'],
                200
            );
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao cadastrar fornecedor.', 'details' => $e->getMessage(), 'trace' => $e->getTrace()], 500);
        }
    }
    public function getFornecedor($id)
    {
        $fornecedor = Fornecedor::find($id)->select(['*'])->first();
        $tiposFornecedores = TipoFornecedor::all();
        return view('Controle.Fornecedor.detalhes', compact('fornecedor', 'tiposFornecedores'));
    }
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nomeFornecedor' => 'required|string',
                'cidadeFornecedor' => 'nullable|string|max:100',
                'estadoFornecedor' => 'nullable|string|max:100',
                'CEP' => 'nullable|string|max:30',
                'enderecoFornecedor' => 'nullable|string',
                'cnpjFornecedor' => 'required|string',
                'tipoFornecedor' => 'required',
                'telefoneFornecedor' => 'nullable|string|max:40',
                'statusFornecedor' => 'required|string',
                'nomeResponsavel' => 'nullable|string',
                'descricaoFornecedor' => 'nullable|string|max:1000',
            ]);
            Fornecedor::where('ID', $request['id'])->update([
                'NOME_FORNECEDOR' => $validatedData['nomeFornecedor'],
                'CNPJ' => $validatedData['cnpjFornecedor'],
                'TIPO_FORNECEDOR_ID' => $validatedData['tipoFornecedor'],
                'CEP' => $validatedData['CEP'] ?? null,
                'ENDERECO' => $validatedData['enderecoFornecedor'] ?? null,
                'CIDADE' => $validatedData['cidadeFornecedor'] ?? null,
                'ESTADO' => $validatedData['estadoFornecedor'] ?? null,
                'TELEFONE' => $validatedData['telefoneFornecedor'] ?? null,
                'IS_DELETED' => $validatedData['statusFornecedor'] == 'Inativo' ? 1 : 0,
                'VENDEDOR' => $validatedData['nomeResponsavel'] ?? null,
                'OBSERVACAO' => $validatedData['descricaoFornecedor'] ?? null,
            ]);
            return response()->json(
                ['success' => true, 'message' => 'Fornecedor atualizado com sucesso.'],
                200
            );
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao atualizar fornecedor.', 'details' => $e->getMessage(), 'trace' => $e->getTrace()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            Fornecedor::softDelete(Fornecedor::class, $id);
            return response()->json(
                ['success' => true, 'message' => 'Fornecedor excluído com sucesso.'],
                200
            );
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao excluir fornecedor.', 'details' => $e->getMessage(), 'trace' => $e->getTrace()], 500);
        }
    }
}