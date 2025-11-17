<?php
namespace App\Http\Controllers\Controle\Fornecedor;
use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use App\Models\TipoFornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class FornecedorController extends Controller
{
    public function index()
    {
        $tiposFornecedores = TipoFornecedor::select('ID', 'TIPO as NOME')->get();
        return view('Controle.Fornecedor.index', compact('tiposFornecedores'));
    }

    public function getDados(Request $request)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $fornecedores = Fornecedor::select(['PUBLIC_ID as ID', 'NOME_FORNECEDOR', 'CNPJ', 'ESTADO', 'CIDADE', 'IS_DELETED'])->join('TIPO_FORNECEDOR', 'FORNECEDOR.TIPO_FORNECEDOR_ID', '=', 'TIPO_FORNECEDOR.ID')->addSelect('TIPO_FORNECEDOR.TIPO as TIPO_FORNECEDOR');
        $fornecedores->when($filtros['cnpj'] ?? null, function ($q, $cnpj) {
            $q->where('CNPJ', '=', $cnpj);
        });
        $fornecedores->when($filtros['nomeFornecedor'] ?? null, function ($q, $nome) {
            $q->where('NOME_FORNECEDOR', 'like', '%' . $nome . '%');
        });
        $fornecedores->when(isset($filtros['statusFornecedor']) && $filtros['statusFornecedor'] !== '', function ($q) use ($filtros) {
            $q->where('IS_DELETED', $filtros['statusFornecedor'] == 'ATIVO' ? 0 : 1);
        });
        $fornecedores->when($filtros['tipoFornecedor'] ?? null, function ($q, $tipoId) {
            $q->where('TIPO_FORNECEDOR_ID', $tipoId);
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
            $validatedData = Validator::make(
                $request->all(),
                [
                    'nomeFornecedor' => 'required|string',
                    'cidadeFornecedor' => 'nullable|string|max:100',
                    'estadoFornecedor' => 'nullable|string|max:100',
                    'CEP' => 'nullable|string|max:30',
                    'enderecoFornecedor' => 'nullable|string',
                    'cnpjFornecedor' => 'required|string|unique:FORNECEDOR,CNPJ',
                    'tipoFornecedor' => 'required',
                    'telefoneFornecedor' => 'nullable|string|max:40',
                    'nomeResponsavel' => 'nullable|string',
                    'descricaoFornecedor' => 'nullable|string|max:1000',
                ],
                [
                    'nomeFornecedor.required' => 'O nome do fornecedor é obrigatório.',
                    'cnpjFornecedor.required' => 'O CNPJ do fornecedor é obrigatório.',
                    'cnpjFornecedor.unique' => 'O CNPJ do fornecedor já está em uso.',
                    'tipoFornecedor.required' => 'O tipo de fornecedor é obrigatório.',
                    'telefoneFornecedor.max' => 'O telefone do fornecedor não pode ter mais de 40 caracteres.',
                    'descricaoFornecedor.max' => 'A descrição do fornecedor não pode ter mais de 1000 caracteres.',
                ]
            );
            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validatedData->errors(),
                    'status' => 422
                ]);
            }
            Fornecedor::insert([
                'NOME_FORNECEDOR' => $request->input('nomeFornecedor'),
                'CNPJ' => $request->input('cnpjFornecedor'),
                'TIPO_FORNECEDOR_ID' => $request->input('tipoFornecedor'),
                'CEP' => $request->input('CEP'),
                'ENDERECO' => $request->input('enderecoFornecedor'),
                'CIDADE' => $request->input('cidadeFornecedor'),
                'ESTADO' => $request->input('estadoFornecedor'),
                'TELEFONE' => $request->input('telefoneFornecedor'),
                'VENDEDOR' => $request->input('nomeResponsavel'),
                'OBSERVACAO' => $request->input('descricaoFornecedor'),
                'USUARIO_CADASTRO' => $request->user()->ID,
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
        $fornecedor = Fornecedor::where('PUBLIC_ID', $id)->first();
        $tiposFornecedores = TipoFornecedor::all();
        return view('Controle.Fornecedor.detalhes', compact('fornecedor', 'tiposFornecedores'));
    }
    public function update(Request $request)
    {
        try {
            $validatedData = Validator::make(
                $request->all(),
                [
                    'nomeFornecedor' => 'required|string',
                    'cidadeFornecedor' => 'nullable|string|max:100',
                    'estadoFornecedor' => 'nullable|string|max:100',
                    'cepFornecedor' => 'required|string|max:30',
                    'enderecoFornecedor' => 'nullable|string',
                    'cnpjFornecedor' => "required|string|unique:FORNECEDOR,CNPJ,$request->id,ID",
                    'tipoFornecedor' => 'required',
                    'telefoneFornecedor' => 'nullable|string|max:40',
                    'nomeResponsavel' => 'nullable|string',
                    'descricaoFornecedor' => 'nullable|string|max:1000',
                ],
                [
                    'nomeFornecedor.required' => 'O nome do fornecedor é obrigatório.',
                    'cnpjFornecedor.required' => 'O CNPJ do fornecedor é obrigatório.',
                    'cnpjFornecedor.unique' => 'O CNPJ do fornecedor já está em uso.',
                    'tipoFornecedor.required' => 'O tipo de fornecedor é obrigatório.',
                    'telefoneFornecedor.max' => 'O telefone do fornecedor não pode ter mais de 40 caracteres.',
                    'descricaoFornecedor.max' => 'A descrição do fornecedor não pode ter mais de 1000 caracteres.',
                ]
            );
            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validatedData->errors(),
                    'status' => 422
                ]);
            }
            Fornecedor::where('ID', $request->id)->update([
                'NOME_FORNECEDOR' => $request->nomeFornecedor,
                'CNPJ' => $request->cnpjFornecedor,
                'TIPO_FORNECEDOR_ID' => $request->tipoFornecedor,
                'CEP' => $request->cepFornecedor ?? null,
                'ENDERECO' => $request->enderecoFornecedor ?? null,
                'CIDADE' => $request->cidadeFornecedor ?? null,
                'ESTADO' => $request->estadoFornecedor ?? null,
                'TELEFONE' => $request->telefoneFornecedor ?? null,
                'IS_DELETED' => $request->statusFornecedor == 'Inativo' ? 1 : 0,
                'VENDEDOR' => $request->nomeResponsavel ?? null,
                'OBSERVACAO' => $request->descricaoFornecedor ?? null,
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