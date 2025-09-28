@extends('layout')
@section('conteudo')
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary"><i class="bi bi-grid-1x2"></i> Módulo de Obras</h1>
        <p class="text-muted">Aqui você pode gerenciar os documentos das obras da empresa
            {{ $usuarioView['EMPRESA'] }}
        </p>
    </div>
    {{-- 🔍 Filtros --}}
    <div id="form" class="card border-2 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-light d-flex align-items-center justify-content-between">
            <h5 class="card-title fw-semibold text-primary mb-0">
                🔍 Filtro de Obras
            </h5>
            <button class="btn btn-sm btn-outline-secondary d-md-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#filtroCollapse" aria-expanded="false">
                <i class="bx bx-slider-alt"></i>
            </button>
        </div>
        <div id="filtroCollapse" class="collapse show">
            <div class="card-body">
                <form id="form" class="row g-3">
                    <div class="col">
                        <label for="codEtiqueta" class="form-label fw-bold">Nome da Obra</label>
                        <input type="search" class="form-control shadow-sm" id="nomeObra" name="nomeObra"
                            placeholder="Ex: 12345">
                    </div>
                    <div class="col">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select class="form-select shadow-sm" id="status" name="status">
                            <option value="todos" selected>Todos</option>
                            <option value="andamento">🔁 Em Andamento</option>
                            <option value="concluidas">✅ Concluídas</option>
                            <option value="erros">⚠️ Em Pausa</option>
                        </select>
                    </div>
                    <div class="col-12 text-end mt-3">
                        <button type="button" class="btn btn-primary px-4 shadow-sm" onclick="filtro()">
                            <i class="bx bx-filter-alt"></i> Aplicar Filtro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- 📋 Tabela --}}
    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark text-center">
                <tr>
                    <th>Nome da Obra</th>
                    <th>Endereço</th>
                    <th>Situação</th>
                    <th>Quantidade de Funcionários</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody class="text-center" id="corpoTabelaObras">
            </tbody>
        </table>
    </div>
    <div id="paginacaoObras" class="d-flex justify-content-center mt-3"></div>
    </div>
    <script src="{{ asset('js/Utils/listar.js') }}"></script>
    <script src="{{ asset('js/Controle/Obras/index.js') }}"></script>
@endsection