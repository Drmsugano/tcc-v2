@extends('layout')
@section('conteudo')
    <div class="container mt-5">
        <h2 class="mb-4 fw-bold text-secondary">⚙️ Cadastro de Usuários - Empresa ({{ $empresa->NOME_FANTASIA }})</h2>

        <!-- Card do Formulário -->
        <div class="card shadow-lg mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title mb-4 text-primary fw-bold">Cadastrar Novo Usuário</h5>
                <form action="{{ route('admin.usuarios.cadastrar') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <!-- Nome Completo -->
                        <div class="col-md-4">
                            <label for="nome" class="form-label fw-semibold text-secondary">Nome Completo</label>
                            <input type="text" class="form-control shadow-sm border-1" id="nome" name="NOME"
                                placeholder="Digite o nome completo" required>
                        </div>

                        <!-- Usuário -->
                        <div class="col-md-4">
                            <label for="usuario" class="form-label fw-semibold text-secondary">Usuário</label>
                            <input type="text" class="form-control shadow-sm border-1" id="usuario" name="USUARIO"
                                placeholder="Digite o nome de usuário" required>
                        </div>

                        <!-- E-mail -->
                        <div class="col-md-4">
                            <label for="email" class="form-label fw-semibold text-secondary">E-mail</label>
                            <input type="email" class="form-control shadow-sm border-1" id="email" name="EMAIL"
                                placeholder="Digite o e-mail" required>
                        </div>
                        <!-- Senha -->
                        <div class="col">
                            <label for="senha" class="form-label fw-semibold text-secondary">Senha</label>
                            <input type="password" class="form-control shadow-sm border-1" id="senha" name="SENHA"
                                placeholder="Digite a senha" required>
                        </div>
                        <!-- Permissões -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary mb-2">Permissões</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach ($permissao as $permissoesCampos)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="permissoes[]"
                                            value="{{ $permissoesCampos->ID }}" id="perm-{{ $permissoesCampos->ID }}">
                                        <label class="form-check-label" for="perm-{{ $permissoesCampos->ID }}">
                                            {{ $permissoesCampos->NOME_PERMISSAO }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Botão -->
                        <div class="col-12 d-grid mt-3">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                Cadastrar Usuário
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- Card da Tabela -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Lista de Usuários</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark text-white">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Usuário</th>
                                <th>Email</th>
                                <th>Permissões</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($listaUsuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->ID }}</td>
                                    <td>{{ $usuario->NOME }}</td>
                                    <td>{{ $usuario->USUARIO }}</td>
                                    <td>{{ $usuario->EMAIL }}</td>
                                    <td>
                                        @php
                                            // Lista de campos de permissões do usuário
                                            $permissoesCampos = collect($usuario)->filter(function ($value, $key) {
                                                return str_starts_with($key, 'ROSFIELD_') && $value;
                                            });
                                        @endphp

                                        @if($permissoesCampos->isNotEmpty())
                                            @foreach($permissoesCampos as $campo => $valor)
                                                @php
                                                    // Remove ROSFIELD_ do nome para mostrar a permissão
                                                    $nomePermissao = str_replace('ROSFIELD_', '', $campo);
                                                @endphp
                                                <span class="badge bg-info text-dark me-1">{{ $nomePermissao }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Nenhuma</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-outline-warning me-1"> ✏️ Editar</a>
                                        <form method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Nenhum usuário cadastrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection