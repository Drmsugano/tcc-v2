@extends('layout')
@section('conteudo')
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary"><i class="bi bi-grid-1x2"></i> Módulo de EPI</h1>
        <p class="text-muted">Aqui você pode gerenciar os EPI's da empresa {{ $usuarioView['EMPRESA'] }}</p>
    </div>
    <div class="container mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <form id="formNovoEPI">
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <label for="caEPI" class="form-label fw-bold">CA do EPI</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-shield"></i></span>
                                <input type="number" class="form-control" id="caEPI" name="ca" placeholder="Ex: 12345"
                                    required>
                                <button class="btn btn-outline-primary" type="button"
                                    onclick="procurarCA(document.getElementById('caEPI').value)">
                                    <i class="bx bx-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="nomeEPI" class="form-label fw-bold">Nome do EPI</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-text"></i></span>
                                <input type="text" class="form-control" id="nomeEPI" name="nomeEpi"
                                    placeholder="Ex: Capacete" required readonly>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="descricaoEPI" class="form-label fw-bold">Descrição do EPI</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-info-circle"></i></span>
                                <textarea class="form-control" id="descricaoEPI" name="descricaoEpi"
                                    placeholder="Ex: Capacete de proteção" required readonly></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="dataValidade" class="form-label fw-bold">Data de Validade (CA)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                <input type="date" class="form-control" id="dataValidade" name="dataValidade" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fornecedorEPI" class="form-label fw-bold">Fornecedor</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-building"></i></span>
                                <select name="fornecedorEPI" id="fornecedorEPI" class="form-select" required>
                                    <option value="">Selecione um fornecedor</option>
                                    @foreach($fornecedores as $fornecedor)
                                        <option value="{{ $fornecedor->ID }}">{{ $fornecedor->NOME_FORNECEDOR }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="dataAquisicao" class="form-label fw-bold">Data de Validade (Material do EPI)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                <input type="date" class="form-control" id="dataAquisicao" name="dataMaterial" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="quantidadeEPI" class="form-label fw-bold">Quantidade em Estoque</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-box"></i></span>
                                <input type="number" class="form-control" id="quantidadeEPI" name="quantidadeEPI"
                                    placeholder="Ex: 50" min="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary btn-lg" id="btnSalvarEPI">
                            <i class="bx bx-save me-2"></i> Salvar EPI
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mb-3">
        <h3 class="h4 fw-bold">Lista de EPIs</h3>
    </div>
    <form id="pesquisaEpi" class="mb-4">
        <label for="filtroEpi" class="visually-hidden">Pesquisar EPI por CA</label>
        <div class="input-group">
            <input type="number" id="filtroEpi" class="form-control border-primary" placeholder="Pesquisar por CA...">
            <button class="btn btn-outline-primary" onclick="pesquisarEpi(event)">
                <i class="bx bx-search"></i>
            </button>
            <button class="btn btn-outline-danger" type="button" onclick="limparFiltroEpi()">
                <i class="bx bx-x"></i>
            </button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>CA</th>
                    <th>Nome do EPI</th>
                    <th>Descrição</th>
                    <th>Quantidade em Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="corpoTabelaEpi">
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-center">
                        <div id="paginacaoEpi"></div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script src="{{ asset('js/Controle/EPI/index.js') }}"></script>
    <script src="{{ asset('js/Utils/listar.js') }}"></script>
    <script src="{{ asset('js/Utils/form.js') }}"></script>
@endsection