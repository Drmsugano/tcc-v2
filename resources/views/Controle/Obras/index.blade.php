@extends('layout')
@section('conteudo')
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary"><i class="bi bi-grid-1x2"></i> Módulo de Obras</h1>
        <p class="text-muted">Aqui você pode gerenciar os documentos das obras da empresa
            {{ $usuarioView['EMPRESA'] }}
        </p>
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