<?php

namespace App\Http\Controllers\Obras;

use App\Models\DocumentacaoObra;
use App\Models\TipoDocumento;
use App\Http\Controllers\Controller;
use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentacaoObraController extends Controller
{
    public function indexDocumentos(Request $request)
    {
        cache()->set('obra_id', $request->query('id'));
        return view('Documentos.Obras.index', [
            'obras' => Obra::select(['*'])->where('PUBLIC_ID', '=', $request->query('id'))->get(),
            'tipos' => TipoDocumento::all(),
        ]);
    }

    public function getDados(Request $request)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();

        $query = DocumentacaoObra::select([
            'PUBLIC_ID',
            'OBRA_ID',
            'TIPO_DOCUMENTO_ID',
            'NOME_ARQUIVO',
            'DESCRICAO',
            'CAMINHO',
            'DATA_UPLOAD'
        ])->with(['obra:id,NOME_OBRA,ENDERECO', 'tipo:id,NOME']);
        $query->when(
            $filtros['NOME_OBRA'] ?? null,
            fn($q, $v) =>
            $q->whereHas('obra', fn($q2) => $q2->where('NOME_OBRA', 'like', "%$v%"))
        );
        $query->when(
            $filtros['ENDERECO'] ?? null,
            fn($q, $v) =>
            $q->whereHas('obra', fn($q2) => $q2->where('ENDERECO', 'like', "%$v%"))
        );
        $query->when(
            $filtros['TIPO_DOCUMENTO'] ?? null,
            fn($q, $v) =>
            $q->whereHas('tipo', fn($q2) => $q2->where('NOME', 'like', "%$v%"))
        );
        $query->when(
            $filtros['dataInicio'] ?? null,
            fn($q, $v) =>
            $q->where('DATA_UPLOAD', '>=', $v)
        );
        $query->when(
            $filtros['dataFim'] ?? null,
            fn($q, $v) =>
            $q->where('DATA_UPLOAD', '<=', $v)
        );
        $docs = $query->paginate($perPage, ['*'], 'page', $page);
        $dados = $docs->map(function ($m) {
            return [
                'ID' => $m->PUBLIC_ID,
                'NOME_ARQUIVO' => $m->NOME_ARQUIVO,
                'DESCRICAO' => $m->DESCRICAO,
                'CAMINHO' => $m->CAMINHO,
                'TIPO_DOCUMENTO' => $m->tipo->NOME ?? null,
                'OBRA' => $m->obra->NOME_OBRA ?? null,
                'ENDERECO' => $m->obra->ENDERECO ?? null,
                'DATA_UPLOAD' => $m->DATA_UPLOAD,
                'tabela' => 'documentacao_obras',
            ];
        });
        return response()->json([
            'data' => $dados,
            'tabela' => 'documentacaoObrasTable',
            'current_page' => $docs->currentPage(),
            'last_page' => $docs->lastPage(),
            'per_page' => $docs->perPage(),
            'total' => $docs->total(),
            'links' => $docs->linkCollection()->all(),
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'OBRA_ID' => 'required|exists:OBRA,ID',
            'TIPO_DOCUMENTO_ID' => 'required|exists:TIPO_DOCUMENTO,ID',
            'arquivo' => 'required|file|max:5120',
        ]);
        $obraId = $request->OBRA_ID;
        $path = $request->file('arquivo')->store("public/obras/{$obraId}/documentos");
        $url = Storage::url($path);
        $doc = DocumentacaoObra::create([
            'OBRA_ID' => $obraId,
            'TIPO_DOCUMENTO_ID' => $request->TIPO_DOCUMENTO_ID,
            'NOME_ARQUIVO' => $request->file('arquivo')->getClientOriginalName(),
            'CAMINHO' => $url,
            'DESCRICAO' => $request->DESCRICAO,
            'DATA_UPLOAD' => date('Y-m-d'),
        ]);
        return response()->json(['success' => true, 'documento' => $doc]);
    }

    public function destroy($id)
    {
        $doc = DocumentacaoObra::findOrFail($id);
        if ($doc->CAMINHO) {
            $relativePath = str_replace('/storage/', 'public/', $doc->CAMINHO);
            Storage::delete($relativePath);
        }
        $doc->delete();
        return response()->json(['success' => true]);
    }
}
