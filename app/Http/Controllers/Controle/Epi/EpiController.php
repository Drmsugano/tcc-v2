<?php
namespace App\Http\Controllers\Controle\Epi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Epi;
class EpiController extends Controller
{
    public function index()
    {
        return view('Controle.Epi.index');
    }
    public function create()
    {
        return view('Controle.Epi.create');
    }
    public function getDados(Request $request)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $query = Epi::select('PUBLIC_ID as ID', 'NOME', 'DESCRICAO', 'CA', 'QUANTIDADE_ESTOQUE');
        $query->when(
            $filtros['filtroEpi'] ?? null,
            fn($q, $v) =>
            $q->where('CA', trim($v))
        );
        $epis = $query->paginate($perPage, ['*'], 'page', $page);
        $dados = $epis->map(function ($m) {
            return [
                'ID' => $m->ID,
                'NOME' => $m->NOME,
                'DESCRICAO' => $m->DESCRICAO,
                'CA' => $m->CA,
                'QUANTIDADE_ESTOQUE' => $m->QUANTIDADE_ESTOQUE,
                'tabela' => 'epi'
            ];
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
}