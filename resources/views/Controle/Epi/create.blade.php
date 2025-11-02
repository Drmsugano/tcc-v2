@extends('layout')

@section('conteudo')
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-primary"><i class="bx bx-plus-lg"></i> Adicionar Novo EPI</h1>
            <p class="text-muted">Preencha o formulário abaixo para adicionar um novo EPI ao sistema.</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form id="formNovoEPI">
                    {{-- Primeira linha: CA, Nome, Descrição --}}
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <label for="caEPI" class="form-label fw-bold">CA do EPI</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-shield"></i></span>
                                <input type="number" class="form-control" id="caEPI" placeholder="Ex: 12345" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nomeEPI" class="form-label fw-bold">Nome do EPI</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-text"></i></span>
                                <input type="text" class="form-control" id="nomeEPI" placeholder="Ex: Capacete" required
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="descricaoEPI" class="form-label fw-bold">Descrição do EPI</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-info-circle"></i></span>
                                <input type="text" class="form-control" id="descricaoEPI"
                                    placeholder="Ex: Capacete de proteção" required disabled>
                            </div>
                        </div>
                    </div>

                    {{-- Segunda linha: Validade e Quantidade --}}
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="dataValidade" class="form-label fw-bold">Data de Validade (CA)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                <input type="date" class="form-control" id="dataValidade" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="quantidadeEPI" class="form-label fw-bold">Quantidade em Estoque</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-box"></i></span>
                                <input type="number" class="form-control" id="quantidadeEPI" placeholder="Ex: 50" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="dataAquisicao" class="form-label fw-bold">Data de Validade (Material do Epi)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                <input type="date" class="form-control" id="dataAquisicao" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fornecedorEPI" class="form-label fw-bold">Fornecedor</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-building"></i></span>
                                <input type="text" class="form-control" id="fornecedorEPI" placeholder="Ex: Empresa XYZ" required>
                            </div>
                        </div>
                    </div>
                    {{-- Botão de envio --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bx bx-save me-2"></i> Salvar EPI
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection