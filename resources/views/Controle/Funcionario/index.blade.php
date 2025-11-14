@extends('layout')
@section('conteudo')
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary"><i class="bi bi-grid-1x2"></i> Módulo de Funcionários</h1>
        <p class="text-muted">Aqui você pode gerenciar os funcionários da empresa {{ $usuarioView['EMPRESA'] }}
        </p>
    </div>
    <div class="mb-5">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bx bx-user-plus"></i> Novo Funcionário
            </div>
            <div class="card-body p-4">
                <form id="formNovoFuncionario" autocomplete="off">
                    <div class="row mb-4">
                        <div class="col">
                            <label for="nomeFuncionario" class="form-label fw-semibold">Nome do Funcionário</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bx bx-text"></i></span>
                                <input type="text" class="form-control" id="nomeFuncionario" name="nomeFuncionario"
                                    placeholder="Ex: Silvinha Silvana Lima" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="cpfFuncionario" class="form-label fw-semibold">CPF do Funcionário</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bx bx-id-card"></i></span>
                                <input type="text" class="form-control" id="cpfFuncionario" name="cpfFuncionario"
                                    placeholder="Ex: 123.456.789-00" maxlength="14" oninput="formatarCpf(this)" required>
                            </div>
                        </div>
                        <div class="col">
                            <label for="pis" class="form-label fw-semibold">Número do PIS</label>
                            <input type="text" class="form-control" id="pis" name="pis" placeholder="Ex: 123.45678.90-1"
                                maxlength="14" oninput="formatarPis(this)" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="funcaoFuncionario" class="form-label fw-semibold">Função do Funcionário</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bx bx-briefcase"></i></span>
                                <select name="funcaoFuncionario" id="funcaoFuncionario" class="form-select" required>
                                    <option value="" disabled selected>Selecione a Função...</option>
                                    @foreach ($funcao as $funcoes)
                                        <option value="{{ $funcoes->ID }}">{{ $funcoes->NOME }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="dataAdmissao" class="form-label fw-semibold">Data de Admissão</label>
                            <input type="date" name="dataAdmissao" id="dataAdmissao" class="form-control" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="bx bx-eraser me-1"></i> Limpar
                        </button>
                        <button type="submit" class="btn btn-success" id="btnSalvarFornecedor"
                            onclick="enviarCadastro(event)">
                            <i class="bx bx-save me-1"></i> Salvar Funcionário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mb-3">
        <h3 class="h4 fw-bold">Lista de Funcionários</h3>
    </div>
    <form id="pesquisaFuncionario" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="filtroFuncionario" class="form-label">Pesquisar Funcionário por Nome</label>
                <input type="text" id="filtroFuncionario" name="filtroFuncionario" class="form-control border-primary"
                    placeholder="Pesquisar por Nome...">
            </div>
            <div class="col-md-4">
                <label for="statusFuncionario" class="form-label">Status do Funcionário</label>
                <select id="statusFuncionario" name="statusFuncionario" class="form-select">
                    <option value="" selected>Todos</option>
                    <option value="0">Ativo</option>
                    <option value="1">Inativo</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="funcaoFuncionario" class="form-label">Função do Funcionário</label>
                <select id="funcaoFuncionario" class="form-select" name="funcaoFuncionario">
                    <option value="" selected>Todas as Funções</option>
                    @foreach ($funcao as $funcoes)
                        <option value="{{ $funcoes->ID }}">{{ $funcoes->NOME }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4 gap-2">
            <button type="button" class="btn btn-primary px-4" onclick="aplicarFiltro(event)">
                <i class="bx bx-search me-1"></i> Pesquisar
            </button>
            <button type="button" class="btn btn-outline-secondary px-4" id="btnLimparFiltro" onclick="limparFiltro()">
                <i class="bx bx-x me-1"></i> Limpar
            </button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Nome do Funcionário</th>
                    <th>Função</th>
                    <th>Data de Admissão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="corpoTabelaFuncionario">
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-center">
                        <div id="paginacaoFuncionario"></div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script src="{{ asset('js/Controle/Funcionario/index.js') }}"></script>
    <script src="{{ asset('js/Controle/Funcionario/formulario.js') }}"></script>
    <script src="{{ asset('js/Controle/Funcionario/tabela.js') }}"></script>
    <script src="{{ asset('js/Utils/listar.js') }}"></script>
    <script src="{{ asset('js/Utils/form.js') }}"></script>
@endsection