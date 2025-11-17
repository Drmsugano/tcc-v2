@extends('layout')
@section('conteudo')
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">
            <i class="bi bi-person-badge"></i> Lançamento de Treinamento para Funcionário {{ $funcionario->NOME }}
        </h1>
        <p class="text-muted">
            Gerencie facilmente os treinamentos do funcionário
            <strong>{{ $funcionario->NOME }}</strong>
        </p>
    </div>
    <div class="mb-5">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bx bx-user-plus"></i> Treinamentos do Funcionário: {{ $funcionario->NOME }}
            </div>
            <div class="card-body p-4">
                <form id="form-cadastro" autocomplete="off">
                    <div class="row mb-4">
                        <div class="col mb-4">
                            <input type="hidden" id="funcionario_id" name="funcionario_id" value="{{ $funcionario->ID }}">
                            <label for="treinamento" class="form-label fw-semibold">Selecione o Treinamento</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bx bx-text"></i></span>
                                <select name="treinamento" id="treinamento" class="form-select" required>
                                    <option value="" disabled selected>Selecione o Treinamento...</option>
                                    @foreach ($treinamentos as $treinamento)
                                        <option value="{{ $treinamento->ID }}">{{ $treinamento->NOME }} - (Valido por
                                            {{ $treinamento->VALIDADE_MESES }} Meses)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <label for="dataTreinamento" class="form-label fw-semibold">Data do Treinamento</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bx bx-calendar"></i></span>
                                <input type="date" class="form-control" id="dataTreinamento" name="dataTreinamento"
                                    required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" onclick="enviarFormulario(event)">
                                <i class="bx bx-save"></i> Salvar Treinamento
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card shadow border-0 my-2">
        <div class="card-header bg-secondary text-white fw-bold">
            <i class="bx bx-table"></i> Treinamentos Lançados
        </div>
        <div class="card-body p-4">
            <div class="text-center my-3">
                <h2 class="fw-bold text-secondary">
                    <i class="bx bx-filter-alt"></i> Filtros de Treinamentos
                </h2>
                <p class="text-muted">
                    Utilize os filtros abaixo para refinar a lista de treinamentos lançados para o funcionário
                    <strong>{{ $funcionario->NOME }}</strong>
            </div>
            <form id="formFiltro" class="mb-4 my-4">
                <div class="row mb-4">
                    <div class="col">
                        <label for="filtroNome" class="form-label fw-semibold">Nome do Treinamento</label>
                        <select name="filtroNome" id="filtroNome" class="form-select">
                            <option value="" disabled selected>Selecione o Treinamento...</option>
                            @foreach ($treinamentos as $treinamento)
                                <option value="{{ $treinamento->ID }}">{{ $treinamento->NOME }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="filtroData" class="form-label fw-semibold">Data do Treinamento</label>
                        <input type="date" class="form-control" id="filtroData" name="filtroData">
                    </div>
                    <div class="col">
                        <label for="filtroStatus" class="form-label fw-semibold">Status</label>
                        <select name="filtroStatus" id="filtroStatus" class="form-select">
                            <option value="" disabled selected>Selecione o Status...</option>
                            <option value="1">Ativo</option>
                            <option value="0">Vencido</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" onclick="aplicarFiltro()">
                        <i class="bx bx-filter"></i> Aplicar Filtro
                    </button>
                    <button type="button" class="btn btn-secondary ms-2" onclick="limparFiltro()">
                        <i class="bx bx-reset"></i> Limpar Filtro
                    </button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Nome do Treinamento</th>
                            <th>Data do Treinamento</th>
                            <th>Validade</th>
                            <th>Status</th>
                            <th>Usuário Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="corpoTabelaTreinamento">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-center">
                                <div id="paginacaoTabela" class="d-flex justify-content-center mt-4">
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Utils/listar.js') }}"></script>
    <script src="{{ asset('js/Utils/form.js') }}"></script>
    <script src="{{ asset('js/Controle/Funcionario/Treinamento/tabela.js') }}"></script>
    <script src="{{ asset('js/Controle/Funcionario/Treinamento/form.js') }}"></script>
@endsection