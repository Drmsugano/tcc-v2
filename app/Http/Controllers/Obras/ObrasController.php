<?php
namespace App\Http\Controllers\Obras;
use App\Http\Controllers\Controller;
use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

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

    public function store(Request $request)
    {

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
    public function getDados(Request $request)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $query = Obra::select(['PUBLIC_ID', 'NOME_OBRA', 'ENDERECO', 'PAUSA', 'FINALIZADO'])
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