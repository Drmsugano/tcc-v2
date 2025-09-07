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
    public function index()
    {

    }

    public function store(Request $request)
    {

    }
    public function getDados(Request $request)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $query = Obra::select(['ID', 'NOME_OBRA', 'PAUSA', 'FINALIZADO']);
        $query->when(
            $filtros['NOME_OBRA'] ?? null,
            fn($q, $v) =>
            $q->where('NOME_OBRA', 'like', "%$v%")
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
        $obras = $query->paginate($perPage, ['*'], 'page', $page);
        $dados = $obras->map(function ($m) {
            return [
                'ID' => $m->ID,
                'NOME_OBRAS' => $m->NOME_OBRA,
                'STATUS' => $m->PAUSA === 1 && $m->FINALIZADO == 0
                    ? 'PAUSADA'
                    : ($m->FINALIZADO == 1 && $m->PAUSA == 0 ? 'FINALIZADA' : 'ATIVA'),
                'tabela' => 'obras'
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