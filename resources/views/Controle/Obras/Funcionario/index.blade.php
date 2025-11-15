@extends('layout')
@section('conteudo')

    <!-- Cabeçalho -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">
            <i class="bi bi-building me-2"></i> Módulo de Obras
        </h1>
        <p class="text-muted fs-5">
            Gerenciamento de Funcionários da Obra
            <span class="fw-semibold text-dark">{{ $obra->NOME_OBRA }}</span>
        </p>
    </div>

    <!-- Botão Voltar -->
    <div class="mb-4">
        <a class="btn btn-outline-primary shadow-sm"
            href="{{ route('controle.obras.verDetalhes', ['id' => $obra->PUBLIC_ID]) }}">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <!-- Formulário de associação -->
    <form id="formFuncionariosObra">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
            <div class="card-header bg-primary text-white rounded-top-4 py-3">
                <h4 class="mb-0 d-flex align-items-center">
                    <i class="bi bi-people-fill me-2 fs-4"></i> Funcionários na Obra
                </h4>
            </div>

            <div class="card-body p-4">
                <div class="row g-3 align-items-end">

                    <div class="col">
                        <label class="form-label fw-semibold text-secondary">Selecionar Funcionário</label>
                        <select name="funcionario" id="funcionario" class="form-select form-select-lg shadow-sm">
                            <option value="">Selecione um Funcionário</option>
                            @foreach ($funcionarios as $funcionario)
                                <option value="{{ $funcionario->ID }}">{{ $funcionario->NOME }}</option>
                            @endforeach
                        </select>
                        <small class="d-block mt-2 mb-3">
                            <a href="{{ route('controle.funcionario') }}" class="text-decoration-none">
                                <i class="bi bi-person-plus me-1"></i> Adicionar novo funcionário
                            </a>
                        </small>
                    </div>
                </div>
                <div class="col text-end d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm" onclick="enviarFormulario(event)">
                        <i class="bi bi-plus-circle me-1"></i> Adicionar
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Tabela -->
    <form id="formFiltro">
        <div class="row g-3 align-items-end mb-3">
            <div class="col">
                <label class="form-label fw-semibold text-secondary">Filtrar por Nome</label>
                <input type="text" name="nomeFuncionario" class="form-control form-control-lg shadow-sm" id="filtroNome"
                    placeholder="Digite o nome">
            </div>
            <div class="col">
                <label class="form-label fw-semibold text-secondary">Filtrar por Função</label>
                <select id="filtroFuncao" name="funcaoFuncionario" class="form-select form-select-lg shadow-sm">
                    <option value="">Selecione uma Função</option>
                    @foreach ($funcoes as $funcao)
                        <option value="{{ $funcao->ID }}">{{ $funcao->NOME }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label class="form-label fw-semibold text-secondary">Filtrar por Status</label>
                <select name="statusFuncionario" class="form-select form-select-lg shadow-sm">
                    <option value="">Selecione um Status</option>
                    <option value="ATIVO">Ativo</option>
                    <option value="INATIVO">Inativo</option>
                </select>
            </div>
        </div>
    </form>
    <div class="col text-end d-flex justify-content-end me-3 mb-3">
        <button class="btn btn-secondary btn-lg shadow-sm me-3" onclick="limparFiltro()">
            <i class="bx bx-reset me-1"></i> Limpar
        </button>
        <button class="btn btn-primary btn-lg shadow-sm" onclick="aplicarFiltro()">
            <i class="bx bx-funnel me-1"></i> Filtrar
        </button>
    </div>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-dark text-white rounded-top-4 py-3">
            <h4 class="mb-0 d-flex align-items-center">
                <i class="bi bi-table me-2 fs-4"></i> Lista de Funcionários
            </h4>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Função</th>
                            <th>Status</th>
                            <th>Início na Obra</th>
                            <th>Fim na Obra</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>

                    <tbody id="corpoTabelaFuncionariosObra"></tbody>
                </table>
            </div>

            <div id="paginacaoFuncionarios" class="mt-3"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/Controle/Obras/Funcionario/tabela.js') }}"></script>
    <script src="{{ asset('js/Controle/Obras/Funcionario/form.js') }}"></script>
    <script src="{{ asset('js/Utils/listar.js') }}"></script>
    <script src="{{ asset('js/Utils/form.js') }}"></script>

@endsection