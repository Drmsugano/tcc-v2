@extends('layout')

@section('conteudo')
    <div class="container mt-5">
        <h2 class="mb-4">📊 Dashboard</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Usuários Ativos</h5>
                            <p class="display-5 fw-bold">{{ $usuario }}</p>
                        </div>
                        <a href="#" class="btn btn-light">Gerenciar Usuários</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Obras</h5>
                            <p class="display-5 fw-bold">NaN</p>
                        </div>
                        <a href="#" class="btn btn-light">Gerenciar Obras</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex">
            <!-- Tabela de Usuários -->
            <div class="col md-4 me-3">
                <div class="card shadow-sm mt-4">
                    <div class="card-body p-0">
                        <table class="table t table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th>Usuários</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="corpoTabelaUsuario">
                            </tbody>
                        </table>
                        <center>
                            <div id="paginacaoUsuario" class="mb-3"></div>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col md-5">
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-dark text-white">
                        <b>Obras</b>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#ID</th>
                                    <th>Nome da Obra</th>
                                    <th>Status</th>
                                    <th>Data Cadastro</th>
                                </tr>
                            </thead>
                            <tbody id="corpoTabelaObra">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Utils/listar.js') }}"></script>
    <script src="{{ asset('js/Admin/index.js') }}"></script>
@endsection