<?php
namespace App\Http\Controllers\Controle\Funcionario;
use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\FuncionarioEpi;
use App\Models\Epi;
use App\Models\Funcionario;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class FuncionarioEpiController extends Controller
{
    public function index($id)
    {
        $funcionario = Funcionario::where('PUBLIC_ID', $id)->first();
        $responsaveis = Funcionario::where('EMPRESA_ID', $funcionario->EMPRESA_ID)->get();
        $epiAll = Epi::where('EMPRESA_ID', $funcionario->EMPRESA_ID)->get();
        $epis = Epi::where(['EMPRESA_ID' => $funcionario->EMPRESA_ID])
            ->where('VALIDADE_EPI', '>=', date('Y-m-d'))
            ->where('VALIDADE_MATERIAL', '>=', date('Y-m-d'))
            ->where('QUANTIDADE_ESTOQUE', '>', 0)
            ->get();
        return view('Controle.Funcionario.Epi.index', compact('funcionario', 'epis', 'responsaveis', 'epiAll'));
    }
    public function devolverEpi(Request $request)
    {
        $id = $request->query('id');
        try {
            $epi = FuncionarioEpi::where('ID', $id)->first();
            if ($epi->DATA_DEVOLUCAO != null) {
                return response()->json(['success' => false, 'message' => 'EPI já foi devolvido.'], 400);
            }
            if ($epi) {
                FuncionarioEpi::where('ID', $id)->update([
                    'DATA_DEVOLUCAO' => date('Y-m-d'),
                ]);
                return response()->json(['success' => true, 'message' => 'EPI devolvido com sucesso.']);
            } else {
                return response()->json(['success' => false, 'message' => 'EPI não encontrado.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ocorreu um erro ao devolver o EPI.', 'error' => $e->getMessage()], 500);
        }
    }
    public function removerEpi(Request $request)
    {
        $id = $request->query('id');
        $epi = FuncionarioEpi::where('ID', $id)->first();
        if (!$epi) {
            return response()->json(['success' => false, 'message' => 'EPI não encontrado.'], 404);
        }
        if ($epi->DATA_DEVOLUCAO != null) {
            return response()->json(['success' => false, 'message' => 'Não é possível remover um EPI que já foi devolvido.'], 400);
        }
        try {
            $epiEstoque = Epi::where('ID', $epi->EPI_ID)->first();
            Epi::where('ID', $epi->EPI_ID)->increment('QUANTIDADE_ESTOQUE', $epi->QUANTIDADE);
            $epiEstoque->save();
            if ($epi) {
                FuncionarioEpi::where('ID', $id)->delete();
                return response()->json(['success' => true, 'message' => 'EPI removido com sucesso.']);
            } else {
                return response()->json(['success' => false, 'message' => 'EPI não encontrado.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ocorreu um erro ao remover o EPI.', 'error' => $e->getMessage()], 500);
        }
    }
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'epi' => 'required|exists:EPI,ID',
            'dataEntrega' => 'required|date',
            'quantidade' => 'required|integer|min:1',
            'responsavel' => 'required|exists:FUNCIONARIOS,ID',
            'funcionarioId' => 'required|exists:FUNCIONARIOS,ID',
        ], [
            'epi.exists' => 'O EPI selecionado é inválido.',
            'funcionarioId.exists' => 'O funcionário selecionado é inválido.',
            'dataEntrega.required' => 'A data de entrega é obrigatória.',
            'quantidade.required' => 'A quantidade é obrigatória.',
            'responsavel.required' => 'O responsável pela entrega é obrigatório.',
            'responsavel.exists' => 'O responsável pela entrega selecionado é inválido.',
            'quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'quantidade.min' => 'A quantidade deve ser pelo menos 1.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(), 'status' => 422]);
        }
        try {
            $EPI = Epi::where('ID', request()->input('epi'))->first();
            if ($EPI->QUANTIDADE_ESTOQUE < request()->input('quantidade')) {
                return response()->json(['success' => false, 'message' => 'Quantidade solicitada maior que o estoque disponível.'], 400);
            }
            Epi::where('ID', request()->input('epi'))->decrement('QUANTIDADE_ESTOQUE', request()->input('quantidade'));
            FuncionarioEpi::insert([
                'EPI_ID' => request()->input('epi'),
                'DATA_ENTREGA' => request()->input('dataEntrega'),
                'QUANTIDADE' => request()->input('quantidade'),
                'FUNCIONARIO_ID' => request()->input('funcionarioId'),
                'RESPONSAVEL_ENTREGA' => request()->input('responsavel'),
            ]);
            return response()->json(['success' => true, 'message' => 'EPI registrado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ocorreu um erro ao registrar o EPI.', 'error' => $e->getMessage()], 500);
        }
    }
    public function getDados(Request $request, $id)
    {
        $perPage = $request->get('perPage', 20);
        $page = $request->get('page', 1);
        $filtros = $request->all();
        $funcionarioId = Funcionario::where('PUBLIC_ID', $id)->value('ID');
        $query = FuncionarioEpi::select(['FUNCIONARIO_EPI.ID as ID', 'EPI.NOME AS NOME_EPI', 'FUNCIONARIO_EPI.DATA_ENTREGA', 'FUNCIONARIO_EPI.QUANTIDADE', 'RESPONSAVEL.NOME AS NOME_RESPONSAVEL', 'EPI.VALIDADE_EPI', 'EPI.VALIDADE_MATERIAL', 'FUNCIONARIO_EPI.DATA_DEVOLUCAO'])->join('EPI', 'EPI.ID', '=', 'FUNCIONARIO_EPI.EPI_ID')
            ->join('FUNCIONARIOS', 'FUNCIONARIOS.ID', '=', 'FUNCIONARIO_EPI.FUNCIONARIO_ID')
            ->join('FUNCIONARIOS AS RESPONSAVEL', 'RESPONSAVEL.ID', '=', 'FUNCIONARIO_EPI.RESPONSAVEL_ENTREGA')
            ->where('FUNCIONARIO_EPI.FUNCIONARIO_ID', $funcionarioId);
        $query->when(isset($filtros['statusEpi']) && $filtros['statusEpi'] != '', function ($q) use ($filtros) {
            if ($filtros['statusEpi'] == 'Vencido') {
                $q->whereDate('EPI.VALIDADE_EPI', '<', date('Y-m-d'));
            } elseif ($filtros['statusEpi'] == 'Válido') {
                $q->whereDate('EPI.VALIDADE_EPI', '>=', date('Y-m-d'));
            }
        });
        $query->when(isset($filtros['statusMaterial']) && $filtros['statusMaterial'] != '', function ($q) use ($filtros) {
            if ($filtros['statusMaterial'] == 'Vencido') {
                $q->whereDate('EPI.VALIDADE_MATERIAL', '<', date('Y-m-d'));
            } elseif ($filtros['statusMaterial'] == 'Válido') {
                $q->whereDate('EPI.VALIDADE_MATERIAL', '>=', date('Y-m-d'));
            }
        });
        $query->when(isset($filtros['statusUso']) && $filtros['statusUso'] != '', function ($q) use ($filtros) {
            if ($filtros['statusUso'] == 'Em uso') {
                $q->whereNull('FUNCIONARIO_EPI.DATA_DEVOLUCAO');
            } elseif ($filtros['statusUso'] == 'Devolvido') {
                $q->whereNotNull('FUNCIONARIO_EPI.DATA_DEVOLUCAO');
            }
        });
        $query->when(isset($filtros['filtroEpi']) && $filtros['filtroEpi'] != '', function ($q) use ($filtros) {
            $q->where('EPI.ID', $filtros['filtroEpi']);
        });
        $funcionarioEpis = $query->paginate($perPage, ['*'], 'page', $page);
        $dados = $funcionarioEpis->map(function ($item) {
            return [
                'ID' => $item->ID,
                'NOME_EPI' => $item->NOME_EPI,
                'DATA_ENTREGA' => date('d/m/Y', strtotime($item->DATA_ENTREGA)),
                'DATA_DEVOLUCAO' => $item->DATA_DEVOLUCAO ? date('d/m/Y', strtotime($item->DATA_DEVOLUCAO)) : '---',
                'QUANTIDADE' => $item->QUANTIDADE,
                'RESPONSAVEL_ENTREGA' => $item->NOME_RESPONSAVEL,
                'STATUS_EPI' => date('Y-m-d') > date('Y-m-d', strtotime($item->VALIDADE_EPI)) ? 'Vencido' : 'Válido',
                'STATUS_MATERIAL' => date('Y-m-d') > date('Y-m-d', strtotime($item->VALIDADE_MATERIAL)) ? 'Vencido' : 'Válido',
                'STATUS_USO' => $item->DATA_DEVOLUCAO == null ? 'Em uso' : 'Devolvido',
                'tabela' => 'funcionarioEpiTable',
            ];
        });
        return response()->json([
            'data' => $dados,
            'tabela' => 'funcionarioEpiTable',
            'current_page' => $funcionarioEpis->currentPage(),
            'last_page' => $funcionarioEpis->lastPage(),
            'per_page' => $funcionarioEpis->perPage(),
            'total' => $funcionarioEpis->total(),
            'links' => $funcionarioEpis->linkCollection()->all(),
        ]);
    }
    public function gerarProtocolo(Request $request, $id)
    {
        $funcionarioEpiId = $request->query('id');
        $funcionarioId = Funcionario::where('PUBLIC_ID', $id)->value('ID');
        $empresa = Empresa::where('ID', $request->user()->EMPRESA_ID)->first();
        $funcionarioEpi = FuncionarioEpi::select(['FUNCIONARIO_EPI.ID as ID', 'EPI.NOME AS NOME_EPI', 'FUNCIONARIO_EPI.DATA_ENTREGA', 'FUNCIONARIO_EPI.QUANTIDADE', 'RESPONSAVEL.NOME AS NOME_RESPONSAVEL', 'EPI.VALIDADE_EPI', 'EPI.VALIDADE_MATERIAL', 'FUNCIONARIO_EPI.DATA_DEVOLUCAO', 'FUNCIONARIOS.NOME AS NOME_FUNCIONARIO','FUNCIONARIOS.CPF AS CPF_FUNCIONARIO'])->join('EPI', 'EPI.ID', '=', 'FUNCIONARIO_EPI.EPI_ID')
            ->join('FUNCIONARIOS', 'FUNCIONARIOS.ID', '=', 'FUNCIONARIO_EPI.FUNCIONARIO_ID')
            ->join('FUNCIONARIOS AS RESPONSAVEL', 'RESPONSAVEL.ID', '=', 'FUNCIONARIO_EPI.RESPONSAVEL_ENTREGA')
            ->where('FUNCIONARIO_EPI.FUNCIONARIO_ID', $funcionarioId)
            ->where('FUNCIONARIO_EPI.ID', $funcionarioEpiId)
            ->first();
        $epis = FuncionarioEpi::select(['EPI.NOME AS NOME_EPI', 'EPI.CA', 'FUNCIONARIO_EPI.QUANTIDADE', 'FUNCIONARIO_EPI.DATA_ENTREGA'])->join('EPI', 'EPI.ID', '=', 'FUNCIONARIO_EPI.EPI_ID')
            ->where('FUNCIONARIO_EPI.FUNCIONARIO_ID', $funcionarioId)
            ->where('FUNCIONARIO_EPI.ID', $funcionarioEpiId)
            ->get();
        if (!$funcionarioEpi) {
            return response()->json(['success' => false, 'message' => 'Registro de EPI não encontrado.'], 404);
        }
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('Controle.Funcionario.Epi.Pdf.template', compact('funcionarioEpi', 'empresa', 'epis'));
        return $pdf->stream('protocolo_epi_' . $funcionarioEpi->NOME_EPI . '.pdf');
    }
}