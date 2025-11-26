@extends('layout')
@section('conteudo')
    <div class="container mt-5">
        <h2 class="mb-4 fw-bold text-secondary">⚙️ Edição de Usuários - Empresa ({{ $empresa->NOME_FANTASIA }})</h2>
        <!-- Card do Formulário -->
        <div class="card shadow-lg mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title mb-4 text-primary fw-bold">Editar Usuário {{ $usuario->NOME }}</h5>
                <form id="form-update" method="POST" autocomplete="off">
                    @csrf
                    <div class="row g-4">
                        <input type="hidden" name="PUBLIC_ID" id="PUBLIC_ID" value="{{ $usuario->PUBLIC_ID }}">
                        <div class="col-md-4">
                            <label for="nome" class="form-label fw-semibold text-secondary">Nome Completo</label>
                            <input type="text" class="form-control shadow-sm border" id="nome" name="NOME"
                                value="{{ $usuario->NOME }}" placeholder="Digite o nome completo" required>
                        </div>
                        <div class="col-md-4">
                            <label for="usuario" class="form-label fw-semibold text-secondary">Usuário</label>
                            <input type="text" class="form-control shadow-sm border" id="usuario" name="USUARIO"
                                value="{{ $usuario->USUARIO }}" placeholder="Digite o nome de usuário" required>
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label fw-semibold text-secondary">E-mail</label>
                            <input type="email" class="form-control shadow-sm border" id="email" name="EMAIL"
                                value="{{ $usuario->EMAIL }}" placeholder="Digite o e-mail" required>
                        </div>
                        <div class="col">
                            <label for="senha" class="form-label fw-semibold text-secondary">Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control shadow-sm border" id="senha" name="SENHA"
                                    placeholder="Digite a senha" value="{{ $usuario->SENHA }}">
                                <button type="button" class="btn btn-outline-secondary" id="senhaButton"
                                    onclick="toggleSenha()">
                                    Ver Senha
                                </button>
                            </div>
                            <script>
                                function toggleSenha() {
                                    const senhaInput = document.getElementById('senha');
                                    const senhaButton = document.getElementById('senhaButton');
                                    if (senhaInput.type === 'password') {
                                        senhaInput.type = 'text';
                                        senhaButton.innerHTML = 'Ocultar Senha';
                                    } else {
                                        senhaInput.type = 'password';
                                        senhaButton.innerHTML = 'Ver Senha';
                                    }
                                }
                            </script>
                        </div>
                        <!-- Permissões -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary mb-2">Permissões</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach ($permissao as $permissoesCampos)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="permissoes[]"
                                            value="{{ $permissoesCampos->ID }}" id="perm-{{ $permissoesCampos->ID }}" {{ in_array($permissoesCampos->ID, $usuario->permissoes->pluck('ID')->toArray()) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm-{{ $permissoesCampos->ID }}">
                                            {{ $permissoesCampos->NOME_PERMISSAO }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Botão -->
                        <div class="col-12 d-grid mt-3">
                            <button class="btn btn-primary btn-lg shadow-sm" onclick="enviarFormulario(event)">
                                Editar Usuário
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Utils/form.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.usuarioForm = new Formulario("/Admin/Usuario", "update", "form-update");
        });
        function enviarFormulario(event) {
            event.preventDefault();
            window.usuarioForm.enviarFormulario(event);
        }
    </script>
@endsection