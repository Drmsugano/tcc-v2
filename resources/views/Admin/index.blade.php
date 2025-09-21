@extends('layout')
@section('conteudo')
    <div class="container mt-5">
        <h2 class="mb-4">📊 Área Administrativa</h2>
        {{-- Cards de resumo --}}
        <div class="row g-4 mb-4">
            <div class="col">
                <div class="card text-white bg-primary shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">Usuários Ativos</h5>
                            <p class="display-6 fw-bold">{{ $usuarioCount }}</p>
                        </div>
                        <a href="{{ route('admin.usuarios') }}" class="btn btn-light btn-sm mt-2">Gerenciar Usuários</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-success shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">Obras</h5>
                            <p class="display-6 fw-bold">{{ $obraCount }}</p>
                        </div>
                        <a href="{{ route('admin.obras') }}" class="btn btn-light btn-sm mt-2">Gerenciar Obras</a>
                    </div>
                </div>
            </div>
        </div>
        {{-- Tabelas de Usuários e Obras --}}
        <div class="row g-4">
            {{-- Tabela de Usuários --}}
            <div class="col-lg-6">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-dark text-white">
                        <b>Usuários (Ativas)</b>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nome</th>
                                    <th>Usuário</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="corpoTabelaUsuario">
                                {{-- JS irá popular --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <div id="paginacaoUsuario"></div>
                    </div>
                </div>
            </div>
            {{-- Tabela de Obras --}}
            <div class="col-lg-6">
                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-dark text-white">
                        <b>Obras (Ativas)</b>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nome da Obra</th>
                                    <th>Endereço</th>
                                    <th>Num.Funcionários</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="corpoTabelaObras">
                                {{-- JS irá popular --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <div id="paginacaoObras"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Scripts --}}
    <script src="{{ asset('js/Utils/listar.js') }}"></script>
    <script src="{{ asset('js/Admin/index.js') }}"></script>
@endsection