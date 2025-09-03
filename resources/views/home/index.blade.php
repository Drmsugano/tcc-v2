@extends('layout')
@section('conteudo')
<div class="container mt-4">
    <h2 class="mb-4">📊 Bem-vindo ao Rosfield ERP</h2>
    <div class="row g-4">
        {{-- Administração --}}
        @if ($usuario->ROSFIELD_ADMIN == 1)
        <div class="col-md-4">
            <div class="card h-100 text-center shadow-sm border-0">
                <div class="card-body">
                    <i class='bx bx-cog fs-1 text-dark'></i>
                    <h5 class="card-title mt-3">Administração</h5>
                    <p class="card-text">Gerencie usuários, permissões e parâmetros do sistema.</p>
                    <a href="#" class="btn btn-dark">Entrar</a>
                </div>
            </div>
        </div>
        @endif
        {{-- Financeiro --}}
        @if ($usuario->ROSFIELD_ADMIN == 1 || $usuario->ROSFIELD_FINANCEIRO == 1)
        <div class="col-md-4">
            <div class="card h-100 text-center shadow-sm border-0">
                <div class="card-body">
                    <i class='bx bx-wallet fs-1 text-success'></i>
                    <h5 class="card-title mt-3">Financeiro</h5>
                    <p class="card-text">Controle de contas a pagar, receber e fluxo de caixa.</p>
                    <a href="#" class="btn btn-success">Entrar</a>
                </div>
            </div>
        </div>
        @endif
        {{-- Controle --}}
        @if ($usuario->ROSFIELD_ADMIN == 1 || $usuario->CONTROLE == 1)
        <div class="col-md-4">
            <div class="card h-100 text-center shadow-sm border-0">
                <div class="card-body">
                    <i class='bx bx-group fs-1 text-primary'></i>
                    <h5 class="card-title mt-3">Controle</h5>
                    <p class="card-text">Gestão de processos internos e acompanhamento de atividades.</p>
                    <a href="#" class="btn btn-primary">Entrar</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection