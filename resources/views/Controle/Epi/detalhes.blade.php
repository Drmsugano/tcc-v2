@extends('layout')

@section('conteudo')
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-primary">
                <i class="bi bi-grid-1x2"></i> Módulo de EPI
            </h1>
            <p class="text-muted">
                Aqui você pode gerenciar os EPI's da empresa <strong>{{ $usuarioView['EMPRESA'] }}</strong>
            </p>
        </div>
        <div class="card shadow-sm p-4">
            <h2 class="mb-4 text-primary">Detalhes do EPI</h2>
            <form id="form-update" method="POST">
                <div class="row mb-3">
                    <input type="text" hidden name="id" value="{{ $epi->PUBLIC_ID }}">
                    <div class="col-md-6">
                        <label for="nomeEPI" class="form-label fw-bold">Nome do EPI</label>
                        <input type="text" id="nomeEPI" name="nomeEPI" class="form-control" data-editavel="true"
                            value="{{ $epi->NOME }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="CA" class="form-label fw-bold">CA</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-shield"></i></span>
                            <input type="number" class="form-control" id="caEPI" name="ca" value="{{ $epi->CA }}" data-editavel="true"
                                placeholder="Ex: 12345" readonly>
                            <button class="btn btn-outline-primary" type="button"
                                onclick="procurarCA(document.getElementById('caEPI').value)"  data-editavel="true" data-editavel="true" >
                                <i class="bx bx-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="descricaoEPI" class="form-label fw-bold">Descrição</label>
                    <textarea id="descricaoEPI" name="descricaoEPI" class="form-control" rows="3" data-editavel="true"
                        readonly>{{ $epi->DESCRICAO }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="quantidadeEstoque" class="form-label fw-bold">Quantidade em Estoque</label>
                    <input type="number" id="quantidadeEstoque" name="quantidadeEstoque" class="form-control"
                        data-editavel="true" min="0" value="{{ $epi->QUANTIDADE_ESTOQUE }}" readonly>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="dataValidade" class="form-label fw-bold">Data de Validade (CA)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="date" class="form-control" id="dataValidade" name="dataValidade" value="{{ $epi->VALIDADE_EPI }}" data-editavel="true" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="dataValidadeMaterial" class="form-label fw-bold">Data de Validade (Material)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="date" class="form-control" id="dataValidadeMaterial" name="dataValidadeMaterial" value="{{ $epi->VALIDADE_MATERIAL }}" data-editavel="true" readonly>
                        </div>
                    </div>
                    </div>
                    <div class="row mb-4">
                        <label for="fornecedorEPI" class="form-label fw-bold">Fornecedor</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-building"></i></span>
                            <select name="fornecedorEPI" id="fornecedorEPI" class="form-select" data-editavel="true" readonly>
                                <option value="">Selecione um fornecedor</option>
                                @foreach($fornecedores as $fornecedor)
                                    <option value="{{ $fornecedor->ID }}" {{ $epi->FORNECEDOR_ID == $fornecedor->ID ? 'selected' : '' }}>
                                        {{ $fornecedor->NOME_FORNECEDOR }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary" id="btnHabilitarEdicao" onclick="habilitarEdicao()">Habilitar
                            Edição</button>
                        <button type="button" class="btn btn-outline-secondary ms-2" id="btnCancelarEdicao" onclick="location.reload()">Cancelar
                            Edição</button>
                        <button type="button" class="btn btn-primary ms-2" id="btnSalvarAlteracoes" onclick="editarEPI(event)" disabled>Salvar
                            Alterações</button>
                    </div>
                    </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/Utils/form.js') }}"></script>
    <script src="{{ asset('js/Controle/EPI/detalhes.js') }}"></script>
@endsection