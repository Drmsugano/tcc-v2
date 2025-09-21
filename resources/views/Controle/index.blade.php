@extends('layout')
@section('conteudo')
    <div class="container mt-5">

        <!-- Título -->
        <div class="text-center mb-5">
            <h1 class="fw-bold text-primary"><i class="bi bi-grid-1x2"></i> Módulo de Controle</h1>
            <p class="text-muted">Gerencie EPI, Funcionários e Obras em um só lugar</p>
        </div>

        <div class="row g-3">
            <!-- Controle de EPI -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow border-0 h-100 hover-card">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam text-primary fs-1 mb-3"></i>
                        <h5 class="fw-bold">Controle de EPI</h5>
                        <p class="text-muted">Gerencie documentos, comprovantes de entrega e estoque de EPIs.</p>
                        <a href="" class="btn btn-outline-primary mt-2">
                            Acessar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Funcionários -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow border-0 h-100 hover-card">
                    <div class="card-body text-center">
                        <i class="bi bi-people-fill text-success fs-1 mb-3"></i>
                        <h5 class="fw-bold">Funcionários</h5>
                        <p class="text-muted">Gerencie documentos, arquivos pessoais e histórico de EPIs.</p>
                        <a href="" class="btn btn-outline-success mt-2">
                            Acessar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Obras -->
            <div class="col-md-6 col-lg-4">
                <div class="card shadow border-0 h-100 hover-card">
                    <div class="card-body text-center">
                        <i class="bi bi-building text-warning fs-1 mb-3"></i>
                        <h5 class="fw-bold">Obras</h5>
                        <p class="text-muted">Controle documentos e informações de cada obra.</p>
                        <a href="" class="btn btn-outline-warning mt-2">
                            Acessar
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card shadow border-0 h-100 hover-card">
                    <div class="card-body text-center">
                        <i class="bi bi-bar-chart-line text-danger fs-1 mb-3"></i>
                        <h5 class="fw-bold">Treinamentos</h5>
                        <p class="text-muted">Acesse o controle de treinamentos.</p>
                        <a href="" class="btn btn-outline-danger mt-2">
                            Acessar
                        </a>
                    </div>
                </div>
            </div>
            <!-- Dashboard Geral -->
            @if (in_array('ADMIN', $usuarioView['PERMISSOES'] ?? []))
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow border-0 h-100 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-bar-chart-line text-danger fs-1 mb-3"></i>
                            <h5 class="fw-bold">Dashboard Geral</h5>
                            <p class="text-muted">Resumo de documentos, EPIs, funcionários e obras.</p>
                            <a href="" class="btn btn-outline-danger mt-2">
                                Acessar
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Estilo extra para hover -->
    <style>
        .hover-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection