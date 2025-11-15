@extends('layout')
@section('conteudo')
    <div class="container mt-5">

        <!-- Cabeçalho -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-primary mb-1">
                    🏗️ Detalhes da Obra
                </h2>
                <p class="text-muted mb-0 fs-6">
                    Empresa: <strong>{{ $usuarioView['EMPRESA'] }}</strong>
                </p>
            </div>

            <a href="{{ route('admin.obras.index') }}" class="btn btn-outline-secondary shadow-sm rounded-3 px-4 py-2">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>

        <!-- Card -->
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-4">

                <!-- Título da seção -->
                <h5 class="fw-bold text-secondary mb-4 d-flex align-items-center">
                    <i class="bi bi-clipboard-check text-primary me-2 fs-4"></i>
                    Informações da Obra
                </h5>

                <form id="form-update" method="post">

                    <input type="hidden" name="PUBLIC_ID" value="{{ $obra->PUBLIC_ID }}">

                    <div class="row g-4">

                        <!-- Nome -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Nome da Obra</label>
                            <input type="text" class="form-control form-control-lg shadow-sm rounded-3"
                                   name="NOME_OBRA" value="{{ $obra->NOME_OBRA }}" required>
                        </div>

                        <!-- Endereço -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Endereço</label>
                            <input type="text" class="form-control form-control-lg shadow-sm rounded-3"
                                   name="ENDERECO" value="{{ $obra->ENDERECO }}" required>
                        </div>

                        <!-- Datas -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Data de Início</label>
                            <input type="date" class="form-control form-control-lg shadow-sm rounded-3"
                                   name="DATA_INICIO" value="{{ $obra->DATA_INICIO }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Data de Fim</label>
                            <input type="date" class="form-control form-control-lg shadow-sm rounded-3"
                                   name="DATA_FIM" value="{{ $obra->DATA_FIM ?? '' }}">
                        </div>

                    </div>

                    <!-- Pausa / Finalizado -->
                    <div class="row g-4 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Pausa</label>
                            <select name="PAUSA" id="pausa"
                                    class="form-select form-select-lg shadow-sm rounded-3">
                                <option value="0" {{ $obra->PAUSA == 0 ? 'selected' : '' }}>Não</option>
                                <option value="1" {{ $obra->PAUSA == 1 ? 'selected' : '' }}>Sim</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Finalizado</label>
                            <select name="FINALIZADO" id="finalizado"
                                    class="form-select form-select-lg shadow-sm rounded-3">
                                <option value="0" {{ $obra->FINALIZADO == 0 ? 'selected' : '' }}>Não</option>
                                <option value="1" {{ $obra->FINALIZADO == 1 ? 'selected' : '' }}>Sim</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botão -->
                    <div class="d-grid mt-5">
                        <button class="btn btn-primary btn-lg rounded-4 shadow-sm py-3 fw-bold"
                                type="submit"
                                style="font-size: 1.1rem;"
                                onclick="enviarFormulario(event, 'form-update')">
                            <i class="bx bx-save2 me-1"></i> Atualizar Obra
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Utils/form.js') }}"></script>
    <script src="{{ asset('js/Admin/Obras/form.js') }}"></script>
@endsection
