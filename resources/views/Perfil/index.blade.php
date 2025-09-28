@extends('layout')
@section('conteudo')
<div class="container mt-5">

    <!-- Título da Página -->
    <div class="text-center mb-4">
        <h1 class="fw-bold text-primary"><i class="bi bi-person-circle"></i> Meu Perfil</h1>
        <p class="text-muted">Detalhes da sua conta e permissões</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Card de Informações -->
            <div class="card shadow border-0 mb-4">
                <div class="card-body">
                    <div class="row g-3">

                        <!-- Nome -->
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded d-flex align-items-center">
                                <i class="bi bi-person fs-3 text-primary me-3"></i>
                                <div>
                                    <h6 class="text-secondary mb-1">Nome</h6>
                                    <span class="fw-bold">{{ $usuario->NOME }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded d-flex align-items-center">
                                <i class="bi bi-envelope fs-3 text-primary me-3"></i>
                                <div>
                                    <h6 class="text-secondary mb-1">Email</h6>
                                    <span class="fw-bold">{{ $usuario->EMAIL }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Empresa -->
                        <div class="col-12">
                            <div class="p-3 bg-light rounded d-flex align-items-center">
                                <i class="bi bi-building fs-3 text-primary me-3"></i>
                                <div>
                                    <h6 class="text-secondary mb-1">Empresa</h6>
                                    <span class="fw-bold">{{ $usuario->empresa->NOME_FANTASIA }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Card de Permissões -->
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-shield-lock"></i> Permissões</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($usuario->permissoes as $permissao)
                            <span class="badge rounded-pill bg-success fs-6">
                                <i class="bi bi-check-circle me-1"></i>{{ $permissao->NOME_PERMISSAO }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
