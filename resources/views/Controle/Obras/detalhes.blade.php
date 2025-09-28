@extends('layout')
@section('conteudo')
    @php
        $obraSituacao = 'bg-primary';
        $situacao = 'Em Andamento';
        if ($obra->PAUSA == 1) {
            $obraSituacao = 'bg-warning';
            $situacao = 'Em Pausa';
        } elseif ($obra->DATAFIM !== null && $obra->FINALIZADO == 1) {
            $obraSituacao = 'bg-success';
            $situacao = "Concluida";
        }
    @endphp
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">
            <i class="bi bi-building"></i> Módulo de Obras
        </h1>
        <p class="text-muted fs-5">
            Gerenciamento da obra <span class="fw-semibold text-dark">{{ $obra->NOME_OBRA }}</span>
        </p>
    </div>
    <div class="card shadow-lg border-0 rounded-4 mb-3">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0"><i class="bi bi-info-circle"></i> Detalhes da Obra</h4>
        </div>
        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1 text-secondary">🏗️ <strong>Nome da Obra</strong></p>
                    <p class="fs-5">{{ $obra->NOME_OBRA }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-secondary">📍 <strong>Endereço</strong></p>
                    <p class="fs-5">{{ $obra->ENDERECO }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1 text-secondary">⚡ <strong>Status</strong></p>
                    <span class="badge {{ $obraSituacao }} fs-6 px-3 py-2">
                        {{ $situacao }}
                    </span>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-secondary">🏢 <strong>Empresa</strong></p>
                    <p class="fs-5">{{ $obra->empresa->NOME_FANTASIA }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1 text-secondary">👷 <strong>Quantidade de Funcionários</strong></p>
                    <span class="fs-5 fw-bold text-primary">{{ $obra->funcionarios_count }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Cards extras -->
    <div class="row g-4">
        <!-- Documentos -->
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4 h-100 text-center p-4">
                <div class="card-body">
                    <i class="bi bi-file-earmark-text text-primary" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 fw-bold">Documentos</h5>
                    <p class="text-muted">Acesse os documentos relacionados à obra.</p>
                    <a href="#" class="btn btn-outline-primary rounded-pill px-4">
                        Ver Documentos
                    </a>
                </div>
            </div>
        </div>

        <!-- Funcionários -->
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4 h-100 text-center p-4">
                <div class="card-body">
                    <i class="bi bi-people text-success" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 fw-bold">Funcionários</h5>
                    <p class="text-muted">Gerencie os funcionários vinculados a esta obra.</p>
                    <a href="#" class="btn btn-outline-success rounded-pill px-4">
                        Ver Funcionários
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection