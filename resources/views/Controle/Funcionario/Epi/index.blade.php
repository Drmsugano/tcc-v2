@extends('layout')
@section('conteudo')
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">
            <i class="bi bi-person-badge"></i> Lançamento de EPI para Funcionário {{ $funcionario->NOME }}
        </h1>
        <p class="text-muted">
            Gerencie facilmente os EPIs do funcionário
            <strong>{{ $funcionario->NOME }}</strong>
        </p>
    </div>
    <div class="mb-5">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bx bx-plus-circle"></i> Novo Lançamento de EPI
            </div>
            <div class="card-body p-4">
                <form id="form-cadastro" autocomplete="off">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <input type="hidden" name="funcionarioId" id="funcionarioId" value="{{ $funcionario->ID }}">
                            <label for="epi" class="form-label fw-semibold text-secondary">EPI</label>
                            <select name="epi" id="epi" class="form-select form-select-lg" required>
                                <option value="" disabled selected>Selecione o EPI...</option>
                                @foreach ($epis as $epi)
                                    <option value="{{ $epi->ID }}">{{ $epi->NOME }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="dataEntrega" class="form-label fw-semibold text-secondary">Data de Entrega</label>
                            <input type="date" name="dataEntrega" id="dataEntrega" class="form-control form-control-lg"
                                required>
                        </div>
                        <div class="col">
                            <label for="responsavel" class="form-label fw-semibold text-secondary">Responsável pela
                                Entrega</label>
                            <select name="responsavel" id="responsavel" class="form-select form-select-lg" required>
                                <option value="" disabled selected>Selecione o Responsável...</option>
                                @foreach ($responsaveis as $responsavel)
                                    <option value="{{ $responsavel->ID }}">{{ $responsavel->NOME }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="quantidade" class="form-label fw-semibold text-secondary">Quantidade</label>
                            <input type="number" name="quantidade" id="quantidade" class="form-control form-control-lg"
                                min="1" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-primary btn-lg px-4" onclick="enviarFormulario(event)">
                            <i class="bx bx-save me-2"></i>Salvar Lançamento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="mb-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white fw-bold d-flex align-items-center">
                <i class="bx bx-list-ul me-2"></i> Histórico de Lançamentos de EPI
            </div>

            <form id="formFiltro">
                <div class="card-body bg-light border-bottom">

                    <h6 class="fw-bold text-secondary mb-3">
                        <i class="bx bx-filter-alt me-1"></i> Filtros de Pesquisa
                    </h6>

                    <div class="row g-3">

                        <div class="col-md-3">
                            <label for="filtroEpi" class="form-label fw-semibold text-secondary">EPI</label>
                            <select name="filtroEpi" id="filtroEpi" class="form-select form-select-lg">
                                <option value="" selected>Todos os EPIs...</option>
                                @foreach ($epiAll as $epi)
                                    <option value="{{ $epi->ID }}">{{ $epi->NOME }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="filtroStatus" class="form-label fw-semibold text-secondary">Status do EPI</label>
                            <select name="statusEpi" id="filtroStatus" class="form-select form-select-lg">
                                <option value="" selected>Todos os Status...</option>
                                <option value="Vencido">Vencido</option>
                                <option value="Valido">Valido</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="filtroMaterial" class="form-label fw-semibold text-secondary">Status do
                                Material</label>
                            <select name="statusMaterial" id="filtroMaterial" class="form-select form-select-lg">
                                <option value="" selected>Todos os Status...</option>
                                <option value="Vencido">Vencido</option>
                                <option value="Valido">Valido</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="filtroUso" class="form-label fw-semibold text-secondary">Status do Uso</label>
                            <select name="statusUso" id="filtroUso" class="form-select form-select-lg">
                                <option value="" selected>Todos os Status...</option>
                                <option value="Em uso">Em uso</option>
                                <option value="Devolvido">Devolvido</option>
                            </select>
                        </div>

                    </div>
                </div>
            </form>
            <div class="p-3">
                <button class="btn btn-primary btn-lg w-100 d-flex justify-content-center align-items-center gap-2"
                    onclick="aplicarFiltro(event)">
                    <i class="bx bx-search"></i> Aplicar Filtro
                </button>
            </div>
        </div>
        <div class="card-body p-4">
            <table class="table table-striped table-hover table-sm">
                <thead class="table-primary">
                    <tr>
                        <th>EPI</th>
                        <th>Data de Entrega</th>
                        <th>Data de Devolução</th>
                        <th>Quantidade</th>
                        <th>Responsável pela Entrega</th>
                        <th>Status do EPI</th>
                        <th>Status do Uso</th>
                        <th>Status do Material</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody id="corpoTabela">
                </tbody>
            </table>
            <div id="paginacaoFuncionarios"></div>
        </div>
    </div>
    </div>
    <script src="{{ asset('js/Controle/Funcionario/Epi/tabela.js') }}"></script>
    <script src="{{ asset('js/Controle/Funcionario/Epi/form.js') }}"></script>
    <script src="{{ asset('js/Utils/listar.js') }}"></script>
    <script src="{{ asset('js/Utils/form.js') }}"></script>
@endsection