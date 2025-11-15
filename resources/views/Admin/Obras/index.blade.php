@extends('layout')
@section('conteudo')
    <div class="container mt-5">
        <h2 class="mb-4 fw-bold text-secondary">⚙️ Cadastro de Obras - Empresa ({{ $usuarioView['EMPRESA'] }})</h2>
        <div class="card shadow-lg mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title mb-4 text-primary fw-bold">Cadastrar Nova Obra</h5>
                <form id="form-cadastro" method="POST" autocomplete="off">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label for="nome" class="form-label fw-semibold text-secondary">Nome da Obra</label>
                            <input type="text" class="form-control shadow-sm border" id="nome" name="NOME_OBRA"
                                placeholder="Digite o nome da obra" required>
                        </div>
                        <div class="col-md-4">
                            <label for="endereco" class="form-label fw-semibold text-secondary">Endereço</label>
                            <input type="text" class="form-control shadow-sm border" id="endereco" name="ENDERECO"
                                placeholder="Digite o endereço" required>
                        </div>
                        <div class="col-md-4">
                            <label for="data_inicio" class="form-label fw-semibold text-secondary">Data de Início</label>
                            <input type="date" class="form-control shadow-sm border" id="data_inicio" name="DATA_INICIO"
                                required>
                        </div>
                        <div class="col-12 d-grid mt-3">
                            <button class="btn btn-primary btn-lg shadow-sm" onclick="enviarFormulario(event, 'form-cadastro')">
                                Cadastrar Obra
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark text-center">
                <tr>
                    <th>Nome da Obra</th>
                    <th>Endereço</th>
                    <th>Situação</th>
                    <th>Data Início</th>
                    <th>Data Fim (Prevista)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody class="text-center" id="corpoTabelaObras">
            </tbody>
        </table>
    </div>
    <div id="paginacaoObras" class="d-flex justify-content-center mt-3"></div>
    <script src="{{ asset('js/Admin/Obras/tabela.js') }}"></script>
    <script src="{{ asset('js/Admin/Obras/form.js') }}"></script>
    <script src="{{ asset('js/Utils/listar.js') }}"></script>
    <script src="{{ asset('js/Utils/form.js') }}"></script>
@endsection