<?php

namespace App\Http\Controllers\Obras;

use App\Models\DocumentacaoObra;
use App\Models\TipoDocumento;
use App\Http\Controllers\Controller;
use App\Models\Obra;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $obraId = Obra::select('ID')->where('PUBLIC_ID', cache()->get('obra_id'))->value('ID');
        $query = DocumentacaoObra::select([
            'ID',
            'PUBLIC_ID',
            'OBRA_ID',
            'TIPO_DOCUMENTO_ID',
            'NOME_ARQUIVO',
            'DESCRICAO',
            'CAMINHO',
            'DATA_UPLOAD'
        ])->with(['obra:id,NOME_OBRA', 'tipo:id,NOME'])->where('OBRA_ID', $obraId);
        $docs = $query->paginate($perPage, ['*'], 'page', $page);
        $dados = $docs->getCollection()->map(function ($m) {
            return [
                'ID' => $m->PUBLIC_ID,
                'NOME_ARQUIVO' => $m->NOME_ARQUIVO,
                'DESCRICAO' => $m->DESCRICAO,
                'OBRA' => $m->obra->NOME_OBRA ?? null,
                'tabela' => 'documentacao_obras',
            ];
        });
        $docs->setCollection($dados);
        return response()->json([
            'success' => true,
            'data' => $dados,
            'current_page' => $docs->currentPage(),
            'last_page' => max(1, $docs->lastPage()), // garante >= 1
            'per_page' => $docs->perPage(),
            'total' => $docs->total(),
            'links' => $docs->linkCollection()->all(),
        ]);
    }



    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'TIPO_DOCUMENTO_ID' => 'required|exists:TIPO_DOCUMENTO,ID',
                'arquivo' => 'required|file|max:5120',
            ]);
            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }
            $obraId = Obra::select('ID')->where('PUBLIC_ID', cache()->get('obra_id'))->value('ID');
            $path = $request->file('arquivo')->store("obras/{$obraId}/documentos", 'public');
            $url = Storage::url($path);
            $doc = DocumentacaoObra::create([
                'OBRA_ID' => $obraId,
                'TIPO_DOCUMENTO_ID' => $request->TIPO_DOCUMENTO_ID,
                'NOME_ARQUIVO' => $request->file('arquivo')->getClientOriginalName(),
                'CAMINHO' => str_replace('http://localhost/storage', '', $url),
                'DESCRICAO' => $request->DESCRICAO,
                'PUBLIC_ID' => Str::uuid(),
                'DATA_UPLOAD' => date('Y-m-d'),
            ]);
            return response()->json(['success' => true, 'documento' => $doc]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }


    public function baixar(string $publicId)
    {
        $documento = DocumentacaoObra::where('PUBLIC_ID', $publicId)->firstOrFail();
        // O CAMINHO vem com "/storage/..." → precisamos só do trecho após isso
        $relativePath = $documento->CAMINHO;
        // Verifica se o arquivo realmente existe no disco público
        if (!Storage::disk('public')->exists($relativePath)) {
            return response()->json([
                'error' => 'Arquivo não encontrado.',
                'path' => $relativePath, // útil pra depurar
            ], 404);
        }
        $fileName = $documento->NOME_ARQUIVO ?? 'documento.xlsx';
        $filePath = Storage::disk('public')->path($relativePath);
        return response()->download($filePath, $fileName);
    }

    public function edit($id)
    {
        $documento = DocumentacaoObra::where('PUBLIC_ID', $id)->firstOrFail();
        $tipo = TipoDocumento::select('ID', 'NOME')->get();
        return response()->json([
            'ID' => $documento->PUBLIC_ID,
            'TIPO_DOCUMENTO_ID' => $documento->TIPO_DOCUMENTO_ID,
            'NOME_ARQUIVO' => $documento->NOME_ARQUIVO,
            'DESCRICAO' => $documento->DESCRICAO,
            'TIPO_DOCUMENTO' => $tipo,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'TIPO_DOCUMENTO_ID' => 'required|exists:TIPO_DOCUMENTO,ID',
            'DESCRICAO' => 'nullable|string|max:255',
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
        $documento = DocumentacaoObra::where('PUBLIC_ID', $id)->firstOrFail();
        $documento->TIPO_DOCUMENTO_ID = $request->TIPO_DOCUMENTO_ID;
        $documento->DESCRICAO = $request->DESCRICAO;
        if ($request->hasFile('arquivo')) {
            // Deleta o arquivo antigo
            $relativePath = $documento->CAMINHO;
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
            $obraId = Obra::select('ID')->where('PUBLIC_ID', cache()->get('obra_id'))->value('ID');
            $path = $request->file('arquivo')->store("obras/{$obraId}/documentos", 'public');
            $url = Storage::url($path);
            $documento->CAMINHO = str_replace("http://{$_SERVER['HTTP_HOST']}/storage", '', $url);
            $documento->NOME_ARQUIVO = $request->file('arquivo')->getClientOriginalName();
        }
        $documento->save();
        return response()->json(['success' => true, 'documento' => $documento]);
    }

    public function destroy($id)
    {
        $documento = DocumentacaoObra::where('PUBLIC_ID', $id)->firstOrFail();
        // O CAMINHO vem com "/storage/..." → precisamos só do trecho após isso
        $relativePath = $documento->CAMINHO;
        // Verifica se o arquivo realmente existe no disco público
        if (!Storage::disk('public')->exists($relativePath)) {
            return response()->json([
                'error' => 'Arquivo não encontrado.',
                'path' => $relativePath, // útil pra depurar
            ], 404);
        }
        Storage::disk('public')->delete($relativePath);
        DocumentacaoObra::where('PUBLIC_ID', $id)->delete();
        return response()->json(['success' => true]);
    }
}