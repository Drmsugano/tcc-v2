<?php
namespace App\Http\Controllers\Obras;
use App\Models\DocumentacaoObra;
use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isNull;

class ObrasController extends Controller
{
    public function indexAdmin()
    {
        return view('Admin.Obras.index');
    }

    public function indexControle()
    {
        return view('Controle.Obras.index');
    }
    public function verFuncionarios($id)
    {
        $obra = Obra::where('PUBLIC_ID', $id)->with('funcionarios')->first();
        $funcionarios = Funcionario::where('EMPRESA_ID', $obra->EMPRESA_ID)->get();
        return view('Controle.Obras.Funcionario.index', compact('obra', 'funcionarios'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'NOME_OBRA' => 'required|string|max:255',
                'ENDERECO' => 'required|string|max:500',
                'DATA_INICIO' => 'required|date',
            ],
            [
                'NOME_OBRA.required' => 'O campo Nome da Obra é obrigatório.',
                'ENDERECO.required' => 'O campo Endereço é obrigatório.',
                'DATA_INICIO.required' => 'O campo Data de Início é obrigatório.',
                'DATA_INICIO.date' => 'O campo Data de Início deve ser uma data válida.',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'status' => 422
            ]);
        }
        try {
            Obra::insert([
                ...$request->all(),
                'PUBLIC_ID' => (string) Str::uuid(),
                'EMPRESA_ID' => $request->user()->EMPRESA_ID
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Obra cadastrada com sucesso!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar obra: ' . $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'NOME_OBRA' => 'required|string|max:255',
                'ENDERECO' => 'required|string|max:500',
                'DATA_INICIO' => 'required|date',

                // Regra final
                'DATA_FIM' => [
                    'nullable',
                    'date',
                    'after:DATA_INICIO',
                    'required_if:FINALIZADO,1',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->FINALIZADO == 0 && !is_null($value)) {
                            $fail('A Data de Fim deve ser nula quando a obra NÃO está finalizada.');
                        }
                    },
                ],
            ],
            [
                'DATA_FIM.required_if' => 'O campo Data de Fim é obrigatório quando a obra está finalizada.',
                'DATA_FIM.after' => 'A Data de Fim deve ser posterior à Data de Início.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'status' => 422
            ]);
        }
        try {
            Obra::where('PUBLIC_ID', $request->PUBLIC_ID)->update($request->only(['NOME_OBRA', 'ENDERECO', 'DATA_INICIO', 'DATA_FIM', 'PAUSA', 'FINALIZADO']));
            return response()->json([
                'success' => true,
                'message' => 'Obra atualizada com sucesso!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar obra: ' . $e->getMessage(),
            ]);
        }
    }
    public function destroy($id)
    {
        $obra = Obra::where('PUBLIC_ID', $id)->withCount('funcionarios')->first();
        if ($obra->funcionarios_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Não é possível excluir uma obra que possui funcionários associados.',
            ]);
        }
        $documentacaoCount = DocumentacaoObra::where('OBRA_ID', $obra->ID)->count();
        if ($documentacaoCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Não é possível excluir uma obra que possui documentações associadas.',
            ]);
        }
        try {
            Obra::where('PUBLIC_ID', $id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Obra excluída com sucesso!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir obra: ' . $e->getMessage(),
            ]);
        }
    }
    public function trocar(Request $request)
    {
        if ($request->obra_id == '' || is_null($request->obra_id)) {
            $request->session()->forget('obra_id');
        } else {
            $request->validate([
                'obra_id' => 'required|exists:OBRA,PUBLIC_ID',
            ]);
            $obra = Obra::where('PUBLIC_ID', $request->obra_id)->first();
            $request->session()->put('obra_id', $obra->PUBLIC_ID);
        }
        return back()->with([
            'success' => 'Obra alterada com sucesso!'
        ]);
    }
    public function verDetalhes($id)
    {
        $obra = Obra::where('PUBLIC_ID', $id)->with('empresa')->with('funcionarios')->withCount('funcionarios')->first();
        return view('Controle.Obras.detalhes', compact('obra'));
    }
    public function verDetalhesAdmin($id)
    {
        $obra = Obra::where('PUBLIC_ID', $id)->with('empresa')->with('funcionarios')->withCount('funcionarios')->first();
        return view('Admin.Obras.detalhes', compact('obra'));
    }
    public function getDados(Request $request)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $query = Obra::select(['PUBLIC_ID', 'NOME_OBRA', 'ENDERECO', 'PAUSA', 'FINALIZADO', 'DATA_INICIO', 'DATA_FIM'])
            ->withCount('funcionarios');
        // Filtros
        $query->when(
            $filtros['NOME_OBRA'] ?? null,
            fn($q, $v) =>
            $q->where('NOME_OBRA', 'like', "%$v%")
        );

        $query->when(
            $filtros['ENDERECO'] ?? null,
            fn($q, $v) =>
            $q->where('ENDERECO', 'like', "%$v%")
        );

        $query->when(
            ($filtros['STATUS'] ?? null) === 'FINALIZADA',
            fn($q) =>
            $q->where('FINALIZADO', 1)
        );

        $query->when(
            ($filtros['STATUS'] ?? null) === 'PAUSADA',
            fn($q) =>
            $q->where('PAUSA', 1)
        );

        $query->when(
            $filtros['dataInicio'] ?? null,
            fn($q, $v) =>
            $q->where('DATA_INICIO', '>=', $v)
        );

        $query->when(
            $filtros['dataFim'] ?? null,
            fn($q, $v) =>
            $q->where('DATA_FIM', '<=', $v)
        );

        // Paginação
        $obras = $query->paginate($perPage, ['*'], 'page', $page);
        // Formatação da resposta
        $dados = $obras->map(function ($m) {
            return [
                'ID' => $m->PUBLIC_ID,
                'NOME_OBRA' => $m->NOME_OBRA,
                'ENDERECO' => $m->ENDERECO,
                'QTDE_FUNCIONARIO' => $m->funcionarios_count,
                'STATUS' => match (true) {
                    $m->FINALIZADO == 1 && $m->PAUSA == 0 => 'FINALIZADA',
                    $m->PAUSA == 1 && $m->FINALIZADO == 0 => 'PAUSADA',
                    default => 'ATIVA',
                },
                'DATA_INICIO' => $m->DATA_INICIO ? date('Y-m-d', strtotime($m->DATA_INICIO . ' +1 day')) : null,
                'DATA_FIM' => $m->DATA_FIM ? date('Y-m-d', strtotime($m->DATA_FIM . ' +1 day')) : 'Não definida',
                'tabela' => 'obras',
            ];
        });
        return response()->json([
            'data' => $dados,
            'tabela' => 'obrasTable',
            'current_page' => $obras->currentPage(),
            'last_page' => $obras->lastPage(),
            'per_page' => $obras->perPage(),
            'total' => $obras->total(),
            'links' => $obras->linkCollection()->all(),
        ]);
    }

}