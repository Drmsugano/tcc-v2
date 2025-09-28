@extends('layout')
@section('conteudo')
        <div class="text-center mb-5">
            <h1 class="fw-bold text-primary"><i class="bi bi-grid-1x2"></i> Módulo de EPI</h1>
            <p class="text-muted">Aqui você pode gerenciar os EPI's da empresa {{ $usuarioView->empresa->NOME_FANTASIA }}</p>
        </div>
@endsection