<?php
namespace App\Http\Controllers\Controle\Funcionario;
use App\Http\Controllers\Controller;
use App\Models\DocumentoFuncionario;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentacaoFuncionarioController extends Controller
{
    public function index($id)
    {
        $funcionario = Funcionario::where('PUBLIC_ID', $id)->firstOrFail();
        return view('Controle.Funcionario.documentos', compact('funcionario'));
    }

    public function getDados(Request $request, $id)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $funcionario = Funcionario::where('PUBLIC_ID', $id)->firstOrFail();
        $documentos = DocumentoFuncionario::where('FUNCIONARIO_ID', $funcionario->ID)->where('IS_DELETED', false);
        $documentos = $documentos->paginate($perPage, ['*'], 'page', $page);
        $dados = $documentos->map(function ($item) {
            return [
                'ID' => $item->ID,
                'NOME' => $item->NOME,
                'DESCRICAO' => $item->DESCRICAO,
                'TIPO' => $item->TIPO,
                'DATA_EMISSAO' => date('d/m/Y', strtotime($item->DATA_EMISSAO)),
                'DATA_VALIDADE' => date('d/m/Y', strtotime($item->DATA_VALIDADE)),
                'ARQUIVO_PATH' => $item->ARQUIVO_PATH,
                'tabela' => 'documentoFuncionarioTable',
            ];
        });
        return response()->json([
            'data' => $dados,
            'tabela' => 'documentoFuncionarioTable',
            'current_page' => $documentos->currentPage(),
            'last_page' => $documentos->lastPage(),
            'per_page' => $documentos->perPage(),
            'total' => $documentos->total(),
            'links' => $documentos->linkCollection()->all(),
        ]);
    }
    public function storeDocumento(Request $request, $id)
    {
        $funcionario = Funcionario::where('PUBLIC_ID', $id)->firstOrFail();
        $validate = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:1000',
            'tipo' => 'required|string|max:100',
            'data_emissao' => 'required|date',
            'data_validade' => 'required|date|after_or_equal:data_emissao',
            'arquivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
        $path = $request->file('arquivo')->store("funcionarios/{$funcionario->ID}/documentos", 'public');
        DocumentoFuncionario::create([
            'FUNCIONARIO_ID' => $funcionario->ID,
            'NOME' => $request->nome,
            'DESCRICAO' => $request->descricao,
            'TIPO_DOCUMENTO' => $request->tipo,
            'DATA_UPLOAD' => $request->data_emissao,
            'CAMINHO' => $path,
            'PUBLIC_ID' => \Illuminate\Support\Str::uuid(),
            'USUARIO_CADASTRO' => $request->user()->ID ?? null,
        ]);

        return response()->json(['success' => true, 'message' => 'Documento cadastrado com sucesso.']);
    }

}